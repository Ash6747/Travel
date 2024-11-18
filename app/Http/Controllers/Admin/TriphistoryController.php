<?php

namespace App\Http\Controllers\Admin;

use \App\Exports\TriphistoryExport;
use App\Http\Controllers\Controller;
use App\Models\Triphistory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TriphistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $triphistories = Triphistory::with(['trip'=> function($query){
            $query->with(['bus'=> function($query){
                $query->with('route');
            }]);
        }, 'driver'])->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $phase = 3;
        $data = compact('triphistories', 'phase');
        return view('admin.triphistory.triphistories')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function morning()
    {
        $triphistories = Triphistory::with(['trip' => function ($query) {
            $query->with(['bus' => function ($query) {
                $query->with('route:id,route_name'); // Load only 'id' and 'name' columns for route
            }])->select('id', 'bus_id'); // Load only necessary columns for trip
        }, 'driver:id,full_name']) // Load only 'id' and 'name' columns for driver
        ->where('phase', 1) // Filter for active phase
        ->get();
        // ->paginate(10); // Paginate results to avoid overloading

        $phase = 1;
        $data = compact('triphistories', 'phase');
        return view('admin.triphistory.triphistories')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function evening()
    {
        $triphistories = Triphistory::with(['trip' => function ($query) {
            $query->with(['bus' => function ($query) {
                $query->with('route:id,route_name'); // Load only 'id' and 'name' columns for route
            }])->select('id', 'bus_id'); // Load only necessary columns for trip
        }, 'driver:id,full_name']) // Load only 'id' and 'name' columns for driver
        ->where('phase', 0) // Filter for inactive phase
        ->get();
        // ->paginate(10); // Paginate results to avoid overloading

        $phase = 0;
        $data = compact('triphistories', 'phase');
        return view('admin.triphistory.triphistories')->with($data);
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

    // public function export(Request $request){
    //     $phase = $request->query('phase');

    //     $triphistories = Triphistory::with(['trip'=>function($query){
    //         $query->with(['bus'=>function($query){
    //             $query->with('route');
    //         }]);
    //     }, 'driver']);
    //     // filter based on status
    //     // if($phase == 0){
    //     //     $triphistories = $query->where('phase', 0)->get();
    //     // } elseif ($phase == 1){
    //     //     $triphistories = $query->where('phase', 1)->get();
    //     // }else{
    //     //     $triphistories = $query->get();
    //     // }

    //     return Excel::download(new Triphistory($triphistories), 'triphistories.xlsx');
    // }

    public function export(Request $request)
{
    $phase = $request->query('phase');

    $query = Triphistory::with(['trip' => function ($query) {
        $query->with(['bus' => function ($query) {
            $query->with('route');
        }]);
    }, 'driver']);

    // Filter based on phase
    if ($phase == 0) {
        $triphistories = $query->where('phase', 0)->get(); // Use get() to fetch the collection
    } elseif ($phase == 1) {
        $triphistories = $query->where('phase', 1)->get();
    } else {
        $triphistories = $query->get();
    }

    // Pass the collection to the TriphistoryExport class
    return Excel::download(new TriphistoryExport($triphistories), 'trips.xlsx');
}

}
