<?php

namespace App\Http\Middleware\Api;

use App\Models\Driver;
use App\Models\Trip;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTripExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $driver = Driver::with(['trip' => function($query){
            $query->where('status', 1);
        }])->findOrFail($request->driver_id);

        if (!$driver->trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip ID not found for authenticated Driver.',
            ], 400);
        }

        $request->merge(['trip_id' => $driver->trip->id]);
        return $next($request);
    }
}
