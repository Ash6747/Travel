<?php

namespace App\Http\Middleware\Api;

use App\Models\Bus;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BusCapacityCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!isset($request['bus_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'Student not selected bus.',
            ], 400);
        }

        $bus = Bus::with(['bookings'=>function($query){
            $today = Carbon::today(); // Current date without time
            $query
            ->where('status', 'approved')
            ->where('end_date', '>', $today)
            ->select('bus_id', DB::raw('COUNT(*) AS total_bookings'))
            ->groupBy('bus_id');
        }])->findOrFail(request('bus_id'));

        if($bus->bookings[0]->total_bookings >= $bus->capacity){
            return response()->json([
                'success' => false,
                'message' => 'No seat available for student.',
            ], 400);
        }
        // dd($bus->bookings[0]->total_bookings);
        return $next($request);
    }
}
