<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TripExport;
use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Driver;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::with(['bus'=>function($query){
            $query->with('route');
        }, 'driver'])->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $status = 3;
        $data = compact('trips', 'status');
        return view('admin.trip.trips')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function enabled()
    {
        $trips = Trip::with(['bus'=>function($query){
            $query->with('route');
        }, 'driver'])->where('status', 1)->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $status = 1;
        $data = compact('trips', 'status');
        return view('admin.trip.trips')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function disabled()
    {
        $trips = Trip::with(['bus'=>function($query){
            $query->with('route');
        }, 'driver'])->where('status', 0)->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $status = 0;
        $data = compact('trips', 'status');
        return view('admin.trip.trips')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $drivers = Driver::where('status', 1)
        ->whereDoesntHave('trip')
        ->get();
        $buses = Bus::with(['route'])
        ->where('status', 1)
        ->whereDoesntHave('trip')
        ->get();

        // dd($buses);
        $url = 'trip.store';
        $title = "Trip Registration";
        $routTitle = "Register";

        $data = compact('url', 'title', 'routTitle', 'drivers', 'buses');
        return view('admin.trip.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        // Validate the incoming data

        $validatedData = $request->validate([
            'bus_id' => [
                'required',
                'exists:'.Bus::class.',id',
                'unique:'.Trip::class.',bus_id'
            ],
            'driver_id' => [
                'required',
                'exists:'.Driver::class.',id',
                'unique:'.Trip::class.',driver_id'
            ],
            'expected_morning_start_time' => [
                'required',
                'date_format:H:i',  // Ensures the time-only format (HH:MM)
            ],
            'expected_morning_end_time' => [
                'required',
                'date_format:H:i',  // Ensures the time-only format (HH:MM)
                // Custom rule to validate end time is greater than start time
                function ($attribute, $value, $fail) use ($request) {
                    $startTime = Carbon::createFromFormat('H:i', $request->input('expected_morning_start_time'));
                    $endTime = Carbon::createFromFormat('H:i', $value);

                    if ($startTime->greaterThanOrEqualTo($endTime)) {
                        $fail('The expected end time must be later than the start time.');
                    }
                }
            ],
            'expected_evening_start_time' => [
                'required',
                'date_format:H:i',  // Ensures the time-only format (HH:MM)
            ],
            'expected_evening_end_time' => [
                'required',
                'date_format:H:i',  // Ensures the time-only format (HH:MM)
                // Custom rule to validate end time is greater than start time
                function ($attribute, $value, $fail) use ($request) {
                    $startTime = Carbon::createFromFormat('H:i', $request->input('expected_evening_start_time'));
                    $morningEndTime = Carbon::createFromFormat('H:i', $request->input('expected_morning_end_time'));
                    $endTime = Carbon::createFromFormat('H:i', $value);

                    if ($startTime->greaterThanOrEqualTo($endTime)) {
                        $fail('The expected end time must be later than the start time.');
                    }

                    if ($morningEndTime->greaterThanOrEqualTo($startTime)) {
                        $fail('The expected evening start time must be later than the morning end time.');
                    }
                }
            ],
            'expected_distance' => [
                'required',
                'numeric',
                'min:0',
                'max:990'
            ],
        ]);

        // Save the data to the database
        Trip::create($validatedData);

        return redirect()->route('trip.table')->with('status', 'Trip added successfully!');

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
        $trip = Trip::with(['bus'=>function($query){
            $query->with('route');
        }, 'driver'])->findOrFail($id);
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $drivers = Driver::where('status', 1)
        ->whereDoesntHave('trip')
        ->get();
        $buses = Bus::with(['route'])
        ->where('status', 1)
        ->whereDoesntHave('trip')
        ->get();

        // dd($buses);
        $url = 'trip.update';
        $title = "Trip Update";
        $routTitle = "Update";

        $data = compact('url', 'title', 'routTitle', 'drivers', 'buses', 'trip', 'id');
        return view('admin.trip.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $trip = Trip::with(['bus'=>function($query){
            $query->with('route');
        }, 'driver'])->findOrFail($id);

        // dd($request);
        $validatedData = $request->validate([
            'bus_id' => [
                'required',
                'exists:'.Bus::class.',id',
                'unique:'.Trip::class.',bus_id,'.$trip->id
            ],
            'driver_id' => [
                'required',
                'exists:'.Driver::class.',id',
                'unique:'.Trip::class.',driver_id,'.$trip->id
            ],
            'expected_morning_start_time' => [
                'required',
                'date_format:H:i',  // Ensures the time-only format (HH:MM)
            ],
            'expected_morning_end_time' => [
                'required',
                'date_format:H:i',  // Ensures the time-only format (HH:MM)
                // Custom rule to validate end time is greater than start time
                function ($attribute, $value, $fail) use ($request) {
                    $startTime = Carbon::createFromFormat('H:i', $request->input('expected_morning_start_time'));
                    $endTime = Carbon::createFromFormat('H:i', $value);

                    if ($startTime->greaterThanOrEqualTo($endTime)) {
                        $fail('The expected end time must be later than the start time.');
                    }
                }
            ],
            'expected_evening_start_time' => [
                'required',
                'date_format:H:i',  // Ensures the time-only format (HH:MM)
            ],
            'expected_evening_end_time' => [
                'required',
                'date_format:H:i',  // Ensures the time-only format (HH:MM)
                // Custom rule to validate end time is greater than start time
                function ($attribute, $value, $fail) use ($request) {
                    $startTime = Carbon::createFromFormat('H:i', $request->input('expected_evening_start_time'));
                    $morningEndTime = Carbon::createFromFormat('H:i', $request->input('expected_morning_end_time'));
                    $endTime = Carbon::createFromFormat('H:i', $value);

                    if ($startTime->greaterThanOrEqualTo($endTime)) {
                        $fail('The expected end time must be later than the start time.');
                    }

                    if ($morningEndTime->greaterThanOrEqualTo($startTime)) {
                        $fail('The expected evening start time must be later than the morning end time.');
                    }
                }
            ],
            'expected_distance' => [
                'required',
                'numeric',
                'min:0',
                'max:990'
            ],
        ]);

        $trip->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('trip.table')->with('status', 'Trip is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        //
        $trip = Trip::find($id);
        // echo "<pre>";
        // print_r($bus);
        if (is_null($trip)) {
            return redirect()->route('trip.table');
        } else {
            $trip->status = !$trip->status;
            $trip->save();
            return redirect()->route('trip.table');
        }
    }

    public function export(Request $request){
        $status = $request->query('status');

        $query = Trip::with(['bus'=>function($query){
            $query->with('route');
        }, 'driver']);
        // filter based on status
        if($status == 0){
            $trips = $query->where('status', 0)->get();
        } elseif ($status == 1){
            $trips = $query->where('status', 1)->get();
        }else{
            $trips = $query->get();
        }

        return Excel::download(new TripExport($trips), 'trips.xlsx');
    }
}
