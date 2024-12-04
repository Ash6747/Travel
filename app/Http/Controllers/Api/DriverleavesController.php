<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driverleave;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverleavesController extends Controller
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
        // Validate the request
        $validator = Validator::make($request->all(), [
            'reason' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                'max:200',  // Limit reason length
            ],
            'driver_id' => 'required|exists:drivers,id',
            'start_date' => 'required|date|after:today', // Start date must be after today
            'duration' => 'required|integer|min:1|max:30', // Duration in days
        ], [
            'reason.regex' => 'The reason may only contain letters, numbers, and spaces.',
            'start_date.after' => 'The start date must be a date after today.',
            'duration.min' => 'The duration must be at least 1 day.',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                "message" => "Error in leave request",
                'error' => $validator->errors(),
            ], 422);
        }

        // Parse validated data
        $validatedData = $validator->validated();
        $startDate = Carbon::parse($validatedData['start_date']);
        $duration = (int) $validatedData['duration'];

        // Calculate end date (add days instead of months)
        $endDate = $startDate->clone()->addDays($duration);
        $validatedData['end_date'] = $endDate->toDateString();

        try {
            // Store the leave data
            Driverleave::create($validatedData);

            return response()->json([
                "status" => true,
                "message" => "Leave requested successfully!",
            ]);
        } catch (\Exception $e) {
            // Catch and log the error
            // \Log::error('Leave request failed: ', [
            //     'error' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            // ]);

            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred while processing your request.',
                // 'error' => $e->getMessage(),
                // 'trace' => $e->getTraceAsString(),
            ], 500);
        }
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
