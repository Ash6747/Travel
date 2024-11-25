<?php

namespace App\Http\Middleware\Api;

use App\Models\Booking;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBookingExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Find the approved booking for the given student_id
        $booking = Booking::where('student_id', $request->student_id)
        ->where('status', 'approved')
        ->first();

        // dd($booking);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Student not booked bus.',
            ], 400);
        }

        // Ensure that payment_date > booking created_at date
        // $paymentDate = $request->payment_date;
        // if ($paymentDate < $booking->created_at->format('Y-m-d')) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Payment date must be after the booking creation date.',
        //     ], 400);
        // }

        // Determine the paid status based on the fee and paid amount
        // $paid_status = $booking->fee > $request->paid_amount ? 'partial' : 'full';

        // Merge all necessary data into the request object
        $request->merge([
            'booking_id' => $booking->id,
            // 'booking_fee' => $booking->fee,
            // 'paid_status' => $paid_status,
        ]);

        return $next($request);
    }
}
