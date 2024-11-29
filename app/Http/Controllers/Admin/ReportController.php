<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['reports', 'bookings', 'course'])
        ->whereHas('reports')
        ->orWhereHas('bookings', function ($query) {
            $query->where('status', 'approved');
        })
        ->get();

        $data = compact('students');
        return view('admin.student.students')->with($data);

    }
    /**
     * Display a listing of the resource.
     */
    public function active()
    {
        $students = Student::with(['reports', 'bookings', 'course'])
        ->whereHas('reports')
        ->orWhereHas('bookings', function ($query) {
            $query->where('status', 'approved')
            ->where('remaining_amount_check', 0)
            ->where('payment_status', '!=','Full');
        })
        ->get();

        $data = compact('students');
        return view('admin.student.students')->with($data);

    }
    /**
     * Display a listing of the resource.
     */
    public function pending()
    {
        $students = Student::with(['reports', 'bookings', 'course'])
        ->whereHas('reports')
        ->orWhereHas('bookings', function ($query) {
            $query->where('status', 'approved')
            ->where('remaining_amount_check', 0);
        })
        ->get();

        $data = compact('students');
        return view('admin.student.students')->with($data);

    }
    /**
     * Display a listing of the resource.
     */
    public function verified()
    {
        $students = Student::with(['reports', 'bookings', 'course'])
        ->whereHas('reports')
        ->orWhereHas('bookings', function ($query) {
            $query->where('status', 'approved')
            ->where('remaining_amount_check', 1);
        })
        ->get();

        $data = compact('students');
        return view('admin.student.students')->with($data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        // $routes = Route::where('status', 1)->get();
        $student = Student::with(['reports', 'bookings', 'course'])
        ->findOrFail($id);
        $url = 'student.store';
        $title = "Transaction Form";
        $routTitle = "Register";
        $data = compact('url', 'title', 'routTitle', 'student', 'id');
        return view('admin.student.transaction')->with($data);
    }

    public function store(Request $request, string $id)
    {
        $today = Carbon::now()->format('Y-m-d');

        $student = Student::with(['bookings'])->findOrFail($id);

        if (!$student->bookings) {
            return redirect()->back()->withErrors(['error' => 'Student does not have any bookings.']);
        }
        $request['paid_status'] = $student->bookings->fee > $request->paid_amount ? 'partial' : 'full';
        $request['student_id'] = $student->id;
        $request['booking_id'] = $student->bookings->id;

        // dd($request);
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'booking_id' => 'required|exists:bookings,id',
            'payment_date' => 'required|date|before_or_equal:' . $today,
            'reciept_token' => [
                'required',
                'string',
                'max:15',
                Rule::unique('transactions', 'reciept_token')
                    ->whereIn('status', ['pending', 'accepted']),
            ],
            'paid_amount' => [
                'required',
                'numeric',
                'min:1',
                'max:' . ($student->bookings->total_amount ?? 0),
            ],
            'reciept_file' => 'required|mimes:png,jpg,jpeg|max:5048',
            'pay_type' => 'required|in:dd,cash,cheque,nft,upi,bank transfer',
            'paid_status' => 'required|in:full,partial',
        ], [
            'reciept_token.unique' => 'The receipt token must be unique for pending or accepted transactions.',
        ]);

        try {
            $recieptPath = $request->file('reciept_file')->store('student/reciepts', 'public');
            $validatedData['reciept_file'] = $recieptPath;

            Transaction::create($validatedData);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing the transaction.']);
        }

        return redirect()->route('student.table')
            ->with('status', 'Booking added trasaction successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::with(['reports'=> function($query){
            $query->with(['transactions', 'stop', 'bus' => function($query){
                $query->with('route');
            }]);
        }, 'bookings'=> function($query){
            $query->with(['transactions', 'cancel', 'stop', 'admin', 'bus' => function($query){
                $query->with('route');
            }]);
        }, 'course', 'user'])
        ->findOrFail($id);

        // dd($student);
        if (is_null($student)) {
            return redirect()->route('student.table');
        } else {
            $url = 'student.update';
            $title = "student Update";
            $routTitle = "Update";
            $data = compact('url', 'title', 'student', 'routTitle', 'id');
            return view('admin.student.form')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $student = Student::with('bookings')->findOrFail($id);
        $user = Auth::user();
        $admin = User::with('admin')->findOrFail($user->id);

        // if(!isset($admin->admin->id)){
        //     return redirect()->route('student.edit', ['id'=>$id])->with('error', 'Admin Not exist');
        // }
        //Admin id for comment
        $validatedData = $request->validate([
            'remaining_amount_check' => ['required', 'in:1'],
            'comment' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                'max:200',  // Optional: Limit comment length
            ],
            'refund' => ['numeric', 'min:0',
            function($att, $val, $fail) use($student){
                if($val > $student->bookings->total_amount){
                    $fail('The refund amount cannot exceed the total booking amount.');
                }
            }]
        ],[
            'comment.regex'=> 'Allows alphabets, numbers, and spaces only',
            'remaining_amount_check.in' => 'The remaining amount check must be set to yes.',
        ]);

        $student->bookings->total_amount -= $request['refund'];
        $student->bookings->refund = $request['refund'];
        $student->bookings->payment_status =
        $student->bookings->total_amount < $student->bookings->fee ? 'Concession' : 'Full';

        // Update student total amount and payment status if student is accepted
        // if ($request->remaining_amount_check == 0) {
        //     return redirect()->route('student.edit', ['id'=>$id])->with('error', "You can not submit 'no'");
        // }else{
        //     // Determine if the payment is partial or full
        //     $student->bookings->payment_status =
        //     $student->bookings->total_amount < $student->bookings->fee ? 'Concession' : 'Full';
        // }

        // if($student->bookings->total_amount < $request['refund']){
        //     return redirect()->route('student.edit', ['id'=>$id])->with('error', "Refund can not be less than total paid amount                                                                                        ");
        // }

        // Update bookings checks
        $student->bookings->remaining_amount_check = $request->remaining_amount_check;

        // Set status based on the checks
        $student->bookings->comment = $request->comment;
        $student->bookings->verified_by = $admin->admin->id;
        // dd($student);
        $student->bookings->save();

        // Return a response
        return redirect()->route('student.edit', ['id'=>$id])->with('status', 'bookings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
