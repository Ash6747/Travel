<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::guard('api')->user();
        $driver = User::with(['driver'=>function($query){
            $query->with('trip');
        }])->findOrFail($user->id);
        // dd($driver->driver->trip);
        $trip = $driver->driver->trip;
        if(isset($trip)){
            return response()->json([
                'status'=> true,
                'message'=> 'Trip assigned to driver',
                'trip'=> $trip
            ]);
        };
        return response()->json([
            'status'=> true,
            'message'=> 'Trip is not assigned to driver',
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
