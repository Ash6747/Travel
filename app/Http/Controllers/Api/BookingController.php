<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Report;
use App\Models\Stop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Get the authenticated user
        // $user = Auth::guard('api')->user();

        // // Retrieve student_id from the authenticated user
        // $studentId = $user->student_id; // or $user->student->id if using a relationship

        // // Add student_id to the request data for validation and creation
        // $request->merge(['student_id' => $studentId]);

        // // Proceed with validation and booking creation
        // $validator = Validator::make($request->all(), [
        //     'bus_id' => 'required|exists:buses,id',
        //     'stop_id' => 'required|exists:stops,id',
        //     'start_date' => 'required|date',
        //     'duration' => 'required|in:1,6,12',
        //     'class' => 'required|in:First,Second,Third,Forth,Fifth,Sixth,Seventh',
        //     'current_academic_year' => 'required|numeric|max:' . date('Y'),
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'errors' => $validator->errors(),
        //     ], 422);
        // }

        // $validatedData = $validator->validated();

        // $startDate = Carbon::parse($validatedData['start_date']);
        // $endDate = $startDate->addMonths((int)$validatedData['duration']);
        // $validatedData['end_date'] = $endDate->toDateString();

        // $stop = Stop::findOrFail($validatedData['stop_id']);
        // $validatedData['fee'] = $stop->fee;
        // $validatedData['student_id'] = $user->student_id;;

        // Booking::create($validatedData);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Booking created successfully!',
        //     'data' => $validatedData,
        // ]);


        $user = Auth::guard('api')->user();
        $student = User::with('student')->findOrFail($user->id);

        if (!$user || !$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student ID not found for authenticated user.',
            ], 400);
        }

        $request->merge(['student_id' => $student->student->id]);

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'bus_id' => 'required|exists:buses,id',
            'stop_id' => 'required|exists:stops,id',
            'start_date' => 'required|date',
            'duration' => 'required|in:1,6,12',
            'class' => 'required|in:First,Second,Third,Forth,Fifth,Sixth,Seventh',
            'current_academic_year' => 'required|numeric|max:' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();

        $startDate = Carbon::parse($validatedData['start_date']);
        $duration = (int) $validatedData['duration'];
        $endDate = $startDate->addMonths($duration);

        $validatedData['end_date'] = $endDate->toDateString();

        $stop = Stop::findOrFail($validatedData['stop_id']);
        $validatedData['fee'] = $stop->fee;

        Booking::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully!',
            'data' => $validatedData,
        ]);
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
    public function createOrUpdateBooking(Request $request){
        $user = Auth::guard('api')->user();
        $student = User::with('student')->findOrFail($user->id);

        if (!$user || !$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student ID not found for authenticated user.',
            ], 400);
        }

        $request->merge(['student_id' => $student->student->id]);

        $today = Carbon::today()->format('Y-m-d');

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'bus_id' => 'required|exists:buses,id',
            'stop_id' => 'required|exists:stops,id',
            'start_date' => 'required|date|after_or_equal:'.$today,
            'duration' => 'required|in:1,6,12',
            'class' => 'required|in:First,Second,Third,Forth,Fifth,Sixth,Seventh',
            'current_academic_year' => 'required|numeric|max:' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();

        $startDate = Carbon::parse($validatedData['start_date']);
        $duration = (int) $validatedData['duration'];
        $endDate = $startDate->addMonths($duration);

        $validatedData['end_date'] = $endDate->toDateString();

        $stop = Stop::findOrFail($validatedData['stop_id']);
        $validatedData['fee'] = $stop->fee;

        Booking::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully!',
            'data' => $validatedData,
        ]);
    }
}
