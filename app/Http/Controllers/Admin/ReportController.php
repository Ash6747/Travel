<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
        $student = Student::with(['reports'=> function($query){
            $query->with(['transactions', 'stop', 'bus' => function($query){
                $query->with('route');
            }]);
        }, 'bookings'=> function($query){
            $query->with(['transactions', 'stop', 'bus' => function($query){
                $query->with('route');
            }]);
        }, 'course', 'user'])
        ->findOrFail($id);

        // dd($student);
        if (is_null($student)) {
            return redirect('routes');
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

        // Update student total amount and payment status if student is accepted
        if ($request->remaining_amount_check == 0) {
            return redirect()->route('student.edit', ['id'=>$id])->with('error', "You can not submit 'no'");
        }else{
            // Determine if the payment is partial or full
            $student->bookings->payment_status =
            $student->bookings->total_amount < $student->bookings->fee ? 'Concession' : 'Full';
        }

        if(!isset($admin->admin->id)){
            return redirect()->route('student.edit', ['id'=>$id])->with('error', 'Admin Not exist');
        }
        //Admin id for comment
        $validatedData = $request->validate([
            'comment' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                'max:200',  // Optional: Limit comment length
            ]
        ],[
            'comment.regex'=> 'Allows alphabets, numbers, and spaces only',
        ]);

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
