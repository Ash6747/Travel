<?php

namespace App\Http\Middleware\Api;

use App\Models\Booking;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBookingExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $today = Carbon::today(); // Current date without time
        // Find the approved booking for the given student_id
        $booking = Booking::where('student_id', request('student_id'))
        ->where('status', 'approved')
        ->where('end_date', '>', $today)
        ->first();

        // dd($booking);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Student not booked bus.',
            ], 400);
        }
        return $next($request);
    }
}
