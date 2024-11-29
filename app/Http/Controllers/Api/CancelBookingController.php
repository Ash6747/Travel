<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CancelBooking;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CancelBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $student = Student::with(['cancel'=>function($cancelQuery){
            $cancelQuery->with(['bus', 'driver', 'admin', 'booking', 'driver']);
        }])->findOrFail(request('student_id'));

        $cancel = $student->cancel;
        if(isset($cancel)){
            return response()->json([
                'status'=> true,
                'message'=> 'Booking cancel request of student',
                'cancelBooking'=> $cancel
            ]);
        }

        return response()->json([
            'status'=> false,
            'message'=> 'Booking cancel request not exist for student'
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function current()
    {
        $student = Student::with([ 'bookings'=>function($bookingQuery){
            $bookingQuery->with(['cancel'=>function($cancelQuery){
                $cancelQuery->with(['bus', 'driver', 'admin', 'driver']);
            }]);
        }])->findOrFail(request('student_id'));

        $cancel = $student->bookings->cancel;
        if(isset($cancel)){
            return response()->json([
                'status'=> true,
                'message'=> 'Booking cancel request of student',
                'cancelBooking'=> $cancel
            ]);
        }

        return response()->json([
            'status'=> false,
            'message'=> 'Booking cancel request not exist for student'
        ]);
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
        // dd($request);
        $student = Student::with(['bookings'=>function($bookingQuery){
            $bookingQuery->with(['bus'=> function($busQuery){
                $busQuery->with(['trip'=>function($tripQuery){
                    $tripQuery->with('driver');
                }]);
            }]);
        }])->findOrFail($request->student_id);

        $validator = Validator::make($request->all(), [
            'booking_id' => ['unique:cancel_bookings,booking_id'],
            'reason' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                'max:200',  // Optional: Limit details length
            ],
            'file' => 'mimes:png,jpg',
        ],[
            'reason.regex'=> 'Allows alphabets, numbers, and spaces only',
        ]);
        // Handle validation failure
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();
        // Handle file uploads (optional)
        if ($request->hasFile('file')) {
            // $file_path = public_path('storage/') . $driver->file;
            // if (file_exists($file_path)) {
            //     @unlink($file_path);
            // }
            $validatedData['file'] = $request->file('file')->store('student/cancelBookingFile', 'public');
        }
        $validatedData['student_id'] = $student->id;
        $validatedData['booking_id'] = $student->bookings->id;
        $validatedData['trip_id'] = $student->bookings->bus->trip->id;
        $validatedData['bus_id'] = $student->bookings->bus->id;
        $validatedData['driver_id'] = $student->bookings->bus->trip->driver->id;

        // dd($student);
        CancelBooking::create($validatedData);

        return response()
        ->json([
            'status'=> true,
            'message' => 'Booking cancelation request is registered successfully'
        ], 201);
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
