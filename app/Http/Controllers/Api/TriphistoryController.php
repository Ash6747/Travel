<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Triphistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class TriphistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $auth = Auth::guard('api')->user();
        $user = User::with(['driver' => function($query) {
            $query->with(['triphistories']);
        }])->findOrFail($auth->id);

        $driver = $user->driver;
        try {
            //code...
            $triphistory = $driver->triphistories;
            if(isset($triphistory)){
                return response()->json([
                    'status'=> true,
                    'message'=> 'Found Trip history for driver',
                    'triphistory'=> $triphistory
                ]);
            }

            return response()->json([
                'status'=> false,
                'message'=> 'Not found Trip history for driver',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status'=> false,
                'message'=> 'Not found Trip history for driver',
            ]);
        }
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
        // Determine phase based on current time
        $now = Carbon::now();
        $phase = $now->format('H') < 12 ? 1 : 0;

        // Check for existing trip with start_meter_reading set and end_meter_reading null
        $user = User::with(['driver' => function($query) {
            $query->with(['trip' => function($query) {
                $query->with(['triphistories' => function($query) {
                    $query->whereDate('created_at', Carbon::today())
                        ->whereNotNull('start_meter_reading')
                        ->whereNull('end_meter_reading');
                }])->where('status', 1);
            }]);
        }])->findOrFail($request->user_id);

        $driver = $user->driver;

        dd($driver);

        if (!isNull($driver->trip) && $driver->trip->triphistories->isNotEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Fill data of end trip first, then create a new trip'
            ]);
        }

        // Validate the request input
        $validator = Validator::make($request->all(), [
            'start_meter_img' => ['required', 'mimes:png,jpg'],
            'start_meter_reading' => ['required', 'numeric', 'min:0', 'max:999999999.99'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        // Store the start meter image and get the path
        $imgFilePath = $request->file('start_meter_img')->store('driver/meters/', 'public');

        // Prepare data for creating a new trip history
        $validatedData = $validator->validated();
        $validatedData['phase'] = $phase;
        $validatedData['start_meter_img'] = $imgFilePath;
        $validatedData['driver_id'] = $driver->id;
        $validatedData['trip_id'] = $driver->trip->id;
        $validatedData['status'] = 'active';

        // Make sure phase is included when creating the new record
        Triphistory::create($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'New trip is created'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $auth = Auth::guard('api')->user();
        $user = User::with(['driver' => function($query) {
            $query->with(['triphistories']);
        }])->findOrFail($auth->id);

        $driver = $user->driver;
        try {
            //code...
            $triphistory = $driver->triphistories->findOrFail($id);
            if(isset($triphistory)){
                return response()->json([
                    'status'=> true,
                    'message'=> 'Found Trip history for driver',
                    'triphistory'=> $triphistory
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status'=> false,
                'message'=> 'Not found Trip history for driver',
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
    public function update(Request $request)
    {
        // dd($request);
        // Determine phase based on current time
        $now = Carbon::now();
        $phase = $now->format('H') < 12 ? 1 : 0;

        // Check for existing trip with start_meter_reading set and end_meter_reading null
        $user = User::with(['driver' => function($query) {
            $query->with(['trip' => function($query) {
                $query->with(['triphistories' => function($query) {
                    $query->whereDate('created_at', Carbon::today())
                        ->whereNotNull('start_meter_reading')
                        ->whereNull('end_meter_reading');
                }]);
            }]);
        }])->findOrFail($request->user_id);

        $driver = $user->driver;
        // dd($driver);

        if ($driver->trip && $driver->trip->triphistories->isNotEmpty()) {
            $triphistory = $driver->trip->triphistories->first();
            // Validate the request input
            $request['distance_traveled'] = $request['end_meter_reading'] - $triphistory->start_meter_reading;
            $validator = Validator::make($request->all(), [
                'end_meter_img' => ['required', 'mimes:png,jpg'],
                'end_meter_reading' => ['required', 'numeric', 'min:'.$triphistory->start_meter_reading, 'max:999999999.99'],
                'distance_traveled' => ['required', 'numeric', 'min: 0', 'max:999999.99'],
                'note' => [
                    'required',
                    'string',
                    'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                    'max:200',  // Optional: Limit comment length
                ]
            ],[
                'note.regex'=> 'Allows alphabets, numbers, and spaces only',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
            }

            // Store the start meter image and get the path
            $imgFilePath = $request->file('end_meter_img')->store('driver/meters/', 'public');

            // Prepare data for creating a new trip history
            $validatedData = $validator->validated();
            $validatedData['phase'] = $phase;
            $validatedData['end_meter_img'] = $imgFilePath;
            $validatedData['driver_id'] = $driver->id;
            $validatedData['trip_id'] = $driver->trip->id;
            // $validatedData['distance_traveled'] = $request['end_meter_reading'] - $triphistory->start_meter_reading;
            $validatedData['status'] = 'complete';

            // Make sure phase is included when creating the new record
            $triphistory->update($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'New trip is ended'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'No active trip, all trip are closed, create new trip'
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function location(Request $request)
    {
        // dd($request);
        // Determine phase based on current time
        $now = Carbon::now();

        // Check for existing trip with start_meter_reading set and end_meter_reading null
        $user = User::with(['driver' => function($query) {
            $query->with(['trip' => function($query) {
                $query->with(['triphistories' => function($query) {
                    $query->whereDate('created_at', Carbon::today())
                        ->whereNotNull('start_meter_reading')
                        ->whereNull('end_meter_reading');
                }]);
            }]);
        }])->findOrFail($request->user_id);

        $driver = $user->driver;
        // dd($driver);

        if ($driver->trip && $driver->trip->triphistories->isNotEmpty()) {
            $triphistory = $driver->trip->triphistories->first();
            // Validate the request input
            $validator = Validator::make($request->all(), [
                'longitude' => ['required', 'numeric', 'between:-180,180'], // Valid range for longitude
                'latitude' => ['required', 'numeric', 'between:-90,90'],    // Valid range for latitude
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
            }

            // Prepare data for creating a new trip history
            $validatedData = $validator->validated();

            // Make sure phase is included when creating the new record
            $triphistory->update($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'location is updated'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'No active trip, all trip are closed, create new trip'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
