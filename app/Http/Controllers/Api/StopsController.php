<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stop;
use Illuminate\Http\Request;

class StopsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $stops = Stop::all();
        if(is_null($stops)){
            return response()->json([
                'status' => false,
                'message' => 'Stops not found',
            ], 404); // Return 200 OK
        }
        return response()->json([
            'status' => true,
            'message' => 'Stops found',
            'stops' => $stops,
        ], 200); // Return 200 OK
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
        $stops = Stop::with(['routes' => function ($query) {
            $query->where('status', 1);
        }])->findOrFail($id);


        if(is_null($stops)){
            return response()->json([
                'status' => false,
                'message' => 'routes not found',
            ], 404); // Return 200 OK
        }
        return response()->json([
            'status' => true,
            'message' => 'routes found',
            'stops-routes' => $stops->routes,
        ], 200); // Return 200 OK

    }

    /**
     * Display the specified resource.
     */
    public function buses(string $id)
    {
        //
        $stops = Stop::with(['routes' => function ($routeQuery) {
            $routeQuery->with(['buses'=> function ($busQuery){
                $busQuery->where('status', 1);
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
