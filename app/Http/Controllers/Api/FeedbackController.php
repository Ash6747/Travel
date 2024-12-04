<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // dd(request('student_id'));
        $student = Student::with(['feedbacks'=>function($feedbacksQuery){
            $feedbacksQuery->with(['bus', 'driver']);
        }])->findOrFail(request('student_id'));

        $feedbacks = $student->feedbacks;
        if(isset($feedbacks)){
            return response()->json([
                'status'=> true,
                'message'=> 'Feedbacks of student',
                'responseObject'=> $feedbacks
            ]);
        }

        return response()->json([
            'status'=> false,
            'message'=> 'Feedbacks not exist for student'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Fetch student and their relationships
        $student = Student::with(['bookings.bus.trip.driver'])->findOrFail($request->student_id);

        // Validate input
        $validator = Validator::make($request->all(), [
            'message' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/', // Allows alphabets, numbers, and spaces only
                'max:200', // Optional: Limit message length
            ],
            'question_1' => ['required', 'in:Very easy,Somewhat easy,Neutral,Somewhat difficult,Very difficult'],
            'question_2' => ['required', 'in:Very clear,Mostly clear,Neutral,Somewhat unclear,Very unclear'],
            'question_3' => ['required', 'in:Very satisfied,Satisfied,Neutral,Dissatisfied,Very dissatisfied'],
            'question_4' => ['required', 'in:Excellent,Good,Average,Below average,Poor'],
            'question_5' => ['required', 'in:Very accurate,Mostly accurate,Neutral,Somewhat inaccurate,Very inaccurate'],
            'question_6' => ['required', 'in:Very convenient,Convenient,Neutral,Inconvenient,Very inconvenient'],
            'question_7' => ['required', 'in:Excellent,Good,Average,Below average,Poor'],
            'question_8' => ['required', 'in:Very likely,Likely,Neutral,Unlikely,Very unlikely'],
            'question_9' => ['required', 'in:Never,Rarely,Sometimes,Often,Always'],
            'question_10' => ['required', 'in:Very easy,Easy,Neutral,Difficult,Very difficult'],
            'question_11' => ['required', 'in:Very satisfied,Satisfied,Neutral,Dissatisfied,Very dissatisfied'],
            'question_12' => ['required', 'in:Very clear,Mostly clear,Neutral,Somewhat unclear,Very unclear'],
            'question_13' => ['required', 'in:Very responsive,Responsive,Neutral,Slow response,No response'],
            'question_14' => ['required', 'in:Very fast,Fast,Average,Slow,Very slow'],
            'question_15' => ['required', 'in:Very satisfied,Satisfied,Neutral,Dissatisfied,Very dissatisfied'],
        ], [
            'message.regex' => 'Allows alphabets, numbers, and spaces only',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'Feedbacks not exist for student',
                'error'=> $validator->errors()
            ], 422);
        }

        // Validated data
        $validatedData = $validator->validated();

        // Extract relationships safely
        $booking = $student->bookings->first(); // Assuming the first booking is relevant
        if (!$booking || !$booking->bus || !$booking->bus->trip || !$booking->bus->trip->driver) {
            return response()->json([
                'status'=> false,
                'message'=> 'Incomplete student trip data.'
            ], 400);
        }

        // Add additional fields
        $validatedData['student_id'] = $student->id;
        $validatedData['booking_id'] = $student->bookings->id;
        $validatedData['trip_id'] = $booking->bus->trip->id;
        $validatedData['bus_id'] = $booking->bus->id;
        $validatedData['driver_id'] = $booking->bus->trip->driver->id;

        // Create feedback
        Feedback::create($validatedData);

        // Success response
        return response()->json([
            'status' => true,
            'message' => 'Feedback is registered successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $student = Student::with(['feedbacks'=>function($feedbacksQuery){
            $feedbacksQuery->with(['bus', 'driver']);
        }])->findOrFail(request('student_id'));


        try {
            //code...
            $feedback = $student->feedbacks->findOrFail($id);
            if(isset($feedback)){
                return response()->json([
                    'status'=> true,
                    'message'=> 'Feedback of student',
                    'responseObject'=> $feedback
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status'=> false,
                'message'=> 'Feedback not exist for student'
            ]);
        }
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
