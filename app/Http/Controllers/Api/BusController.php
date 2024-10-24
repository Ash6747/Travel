<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Stop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $busCounts = DB::table('bookings')
            ->select('bus_id', DB::raw('COUNT(*) as total_bookings'))
            ->where('end_date', '>', Carbon::today())
            ->groupBy('bus_id')
            ->get();

        // Output the result
        return response()->json($busCounts);
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

        $stops = Stop::with(['routes' => function ($routeQuery) {
            $routeQuery->with(['buses'=> function ($busQuery){
                $busQuery->with(['bookings'=> function ($bookQuery){
                    $today = Carbon::today(); // Current date without time

                    $bookQuery->where('end_date', '>', $today)
                    ->select('bus_id', DB::raw('COUNT(*) as total_bookings'))
                    ->groupBy('bus_id')
                    ->get();

                }])->where('status', 1);
            }])->where('status', 1);
        }])->findOrFail($id);

        if(is_null($stops)){
            return response()->json([
                'status' => false,
                'message' => 'Buses not found',
            ], 404); // Return 200 OK
        }
        return response()->json([
            'status' => true,
            'message' => 'Buses found',
            'stops-buses' => $stops->routes[0]->buses,
        ], 200); // Return 200 OK
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
