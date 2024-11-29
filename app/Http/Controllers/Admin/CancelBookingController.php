<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CancelBooking;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CancelBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cancellations = CancelBooking::with(['student', 'bus', 'driver', 'booking'=>function($query){
            $query->with(['student', 'bus'=> function($query){
                    $query->with('route');
                }, 'stop']);
        }])->get();

        $status = '';
        $data = compact('cancellations', 'status');
        return view('admin.cancellation.cancellations')->with($data);
    }

    public function pending()
    {
        $cancellations = CancelBooking::with(['student', 'bus', 'driver', 'booking'=>function($query){
            $query->with(['student', 'bus'=> function($query){
                    $query->with('route');
                }, 'stop']);
        }])
        ->where('status', 'pending')
        ->get();

        $status = 'pending';
        $data = compact('cancellations', 'status');
        return view('admin.cancellation.cancellations')->with($data);
    }

    public function approved()
    {
        // $today = Carbon::today(); // Current date without time
        $cancellations = CancelBooking::with(['student', 'bus', 'driver', 'booking'=>function($query){

            $query->with(['student', 'bus'=> function($query){
                $query->with('route');
            }, 'stop']);
        }])
        ->where('status', 'approved')
        ->get();

        $status = 'approved';
        $data = compact('cancellations', 'status');
        return view('admin.cancellation.cancellations')->with($data);
    }

    public function rejected()
    {
        $cancellations = CancelBooking::with(['student', 'bus', 'driver', 'booking'=>function($query){
            $query->with(['student', 'bus'=> function($query){
                    $query->with('route');
                }, 'stop']);
        }])
        ->where('status', 'rejected')
        ->get();

        $status = 'rejected';
        $data = compact('cancellations', 'status');
        return view('admin.cancellation.cancellations')->with($data);
    }

    // public function expired()
    // {
    //     //
    //     $today = Carbon::today(); // Current date without time

    //     $bookings = Booking::with(['student', 'bus'=> function($query){
    //         $query->with('route');
    //     }, 'stop'])
    //     ->where('status', 'approved')
    //     ->where('end_date', '<', $today)
    //     ->get();
    //     // dd($bookings);
    //     // echo "<pre>";
    //     // print_r($bookings->toArray());
    //     // echo "</pre>";
    //     $status = 'expired';
    //     $data = compact('bookings', 'status');
    //     return view('admin.booking.bookings')->with($data);
    // }

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
    public function store(Request $request, string $id)
    {
        // $today = Carbon::today();
        $student = Student::with(['bookings'=>function($bookingQuery){
            $today = Carbon::today();
            $bookingQuery->with(['bus'=> function($busQuery){
                $busQuery->with(['trip'=>function($tripQuery){
                    $tripQuery->with('driver');
                }]);
            }])
            ->where('status', 'approved')
            ->where('end_date', '>', $today);
        }])->findOrFail($id);

        // $student = Student::with(['bookings'])->findOrFail($id);
        $user = Auth::user();
        $admin = User::with('admin')->findOrFail($user->id);

        // dd($student);
        if(!isset($student->bookings)){
            return redirect()->route('student.edit', ['id'=>$id])->with('error', 'Booking is not present or not approved or expired.');
        }

        $request['booking_id'] = $student->bookings->id;
        //Admin id for comment
        $validatedData = $request->validate([
            'booking_id' => ['unique:cancel_bookings,booking_id'],
            'reason' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                'max:200',  // Optional: Limit details length
            ],
            'resolution' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                'max:200',  // Optional: Limit resolution length
            ],
            'refund' => ['numeric', 'min:0',
            function($att, $val, $fail) use($student){
                if($val > $student->bookings->total_amount){
                    $fail('The refund amount cannot exceed the total booking amount.');
                }
            }],
            'file' => 'mimes:png,jpg,jpeg',
        ],[
            'resolution.regex'=> 'Allows alphabets, numbers, and spaces only',
        ]);

        // dd($student);
        DB::beginTransaction();
        try {
            //code...
            // Handle file uploads (optional)
            if ($request->hasFile('file')) {
                $validatedData['file'] = $request->file('file')->store('student/cancelBookingFile', 'public');
            }
            //Refund
            $student->bookings->total_amount -= $request['refund'];
            $student->bookings->refund = $request['refund'];
            $student->bookings->payment_status =
            $student->bookings->total_amount < $student->bookings->fee ? 'Concession' : 'Full';

            // $validatedData = $validator->validated();
            $validatedData['student_id'] = $student->id;
            // $validatedData['booking_id'] = $student->bookings->id;
            $validatedData['trip_id'] = $student->bookings->bus->trip->id;
            $validatedData['bus_id'] = $student->bookings->bus->id;
            $validatedData['driver_id'] = $student->bookings->bus->trip->driver->id;

            $validatedData['status'] = 'approved';
            $validatedData['verified_by'] = $admin->admin->id;

            // Set status based on the checks
            // $student->bookings->cancel->status = 'approved';
            $student->bookings->status = 'leave';

            // dd($student);
            CancelBooking::create($validatedData);
            $student->bookings->save();

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('student.edit', ['id'=>$id])->with('error', 'Booking get error while updating.'.$th);
        }


        // Return a response
        return redirect()->route('student.edit', ['id'=>$id])->with('status', 'bookings updated successfully.');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd($request);
        $student = Student::with(['bookings'=>function($query){
            $query->with('cancel');
        }])->findOrFail($id);
        $user = Auth::user();
        $admin = User::with('admin')->findOrFail($user->id);

        //Admin id for comment
        $validatedData = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'resolution' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                'max:200',  // Optional: Limit resolution length
            ],
            'refund' => ['numeric', 'min:0',
            function($att, $val, $fail) use($student){
                if($val > $student->bookings->total_amount){
                    $fail('The refund amount cannot exceed the total booking amount.');
                }
            }]
        ],[
            'resolution.regex'=> 'Allows alphabets, numbers, and spaces only',
            // 'status.in' => '',
        ]);

        if($request['status'] == 'approved'){

            //Refund
            $student->bookings->total_amount -= $request['refund'];
            $student->bookings->refund = $request['refund'];
            $student->bookings->payment_status =
            $student->bookings->total_amount < $student->bookings->fee ? 'Concession' : 'Full';

            // Set status based on the checks
            $student->bookings->status = 'leave';
            $student->bookings->save();
        }
        $student->bookings->cancel->resolution = $request->resolution;
        $student->bookings->cancel->verified_by = $admin->admin->id;
        $student->bookings->cancel->status = $request->status;

        $student->bookings->cancel->save();

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
