<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // dd(request('student_id'));
        $student = Student::with(['complaints'=>function($complaintsQuery){
            $complaintsQuery->with(['bus', 'driver']);
        }])->findOrFail(request('student_id'));

        $complaints = $student->complaints;
        if(isset($complaints)){
            return response()->json([
                'status'=> true,
                'message'=> 'Complaints of student',
                'complaints'=> $complaints
            ]);
        }

        return response()->json([
            'status'=> false,
            'message'=> 'Complaints not exist for student'
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
        //
        $student = Student::with(['bookings'=>function($bookingQuery){
            $bookingQuery->with(['bus'=> function($busQuery){
                $busQuery->with(['trip'=>function($tripQuery){
                    $tripQuery->with('driver');
                }]);
            }]);
        }])->findOrFail($request->student_id);

        $validator = Validator::make($request->all(), [
            'details' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                'max:200',  // Optional: Limit details length
            ],
            'complaint_file' => 'mimes:png,jpg',
        ],[
            'details.regex'=> 'Allows alphabets, numbers, and spaces only',
        ]);
        // Handle validation failure
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Store receipt file
        $complaintFilePath = $request->file('complaint_file')->store('student/complaints', 'public');
        $validatedData = $validator->validated();
        $validatedData['complaint_file'] = $complaintFilePath;
        $validatedData['student_id'] = $student->id;
        $validatedData['trip_id'] = $student->bookings->bus->trip->id;
        $validatedData['bus_id'] = $student->bookings->bus->id;
        $validatedData['driver_id'] = $student->bookings->bus->trip->driver->id;

        // dd($student);
        Complaint::create($validatedData);

        return response()
        ->json([
            'status'=> true,
            'message' => 'Complaint is registered successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        //
        $student = Student::with(['complaints'=>function($complaintsQuery){
            $complaintsQuery->with(['bus', 'driver']);
        }])->findOrFail($request->student_id);


        try {
            //code...
            $complaint = $student->complaints->findOrFail($id);
            if(isset($complaint)){
                return response()->json([
                    'status'=> true,
                    'message'=> 'Complaint of student',
                    'complaint'=> $complaint
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status'=> false,
                'message'=> 'Complaint not exist for student'
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