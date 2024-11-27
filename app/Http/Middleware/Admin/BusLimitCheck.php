<?php

namespace App\Http\Middleware\Admin;

use App\Models\Booking;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BusLimitCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $today = Carbon::today(); // Current date without time

        $existingBooking = Booking::with(['bus'=>function($query){
            $query
            ->with(['bookings'=>function($query){
                $today = Carbon::today();

                $query
                ->where('status', 'approved')
                ->where('end_date', '>', $today)
                ->select('bus_id', DB::raw('COUNT(*) AS total_bookings'))
                ->groupBy('bus_id')
                ->first();
            }]);
        }])
        ->findOrFail($request->id);

        // dd($existingBooking->bus->bookings[0]->total_bookings);
        if($existingBooking->bus->bookings[0]->total_bookings >= $existingBooking->bus->capacity){
            return redirect()
            ->route('booking.edit', ['id'=>$request->id])
            ->with('Error', 'No seat available for student.');
        }

        // dd($existingBooking);
        return $next($request);
    }
}
