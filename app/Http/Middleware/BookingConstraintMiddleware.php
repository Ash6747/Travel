<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use App\Models\Report;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BookingConstraintMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('api')->user();
        $student = User::with('student')->findOrFail($user->id);
        $existingBooking = Booking::where('student_id', $student->student->id)->first();

        if ($existingBooking) {
            switch ($existingBooking->status) {
                case 'pending':
                    // Status is 'pending', deny access
                    return response()->json(['message' => 'Already booked by you'], 403);

                case 'rejected':
                    // Status is 'rejected', delete previous booking and allow new one
                    $existingBooking->delete();
                    break;

                case 'approved':
                    if ($existingBooking->remaining_amount_check == 0) {
                        // Status is 'approved' and remaining_amount_check is 0, restrict booking
                        return response()->json(['message' => 'Cannot create new booking, remaining amount due'], 403);
                    } elseif ($existingBooking->remaining_amount_check == 1) {
                        // Status is 'approved' and remaining_amount_check is 1, store old booking in report
                        Report::create([
                            'student_id' => $existingBooking->student_id,
                            'bus_id' => $existingBooking->bus_id,
                            'stop_id' => $existingBooking->stop_id,
                            'old_booking_id' => $existingBooking->id,

                            'start_date' => $existingBooking->start_date,
                            'end_date' => $existingBooking->end_date,
                            'duration' => $existingBooking->duration,
                            'fee' => $existingBooking->fee,
                            'class' => $existingBooking->class,
                            'current_academic_year' => $existingBooking->current_academic_year,

                            'total_amount' => $existingBooking->total_amount,
                            'refund' => $existingBooking->refund,
                            'verified_by' => $existingBooking->verified_by,
                            'payment_status' => $existingBooking->payment_status,
                            'remaining_amount_check' => $existingBooking->remaining_amount_check,
                            'status' => 'expired',
                            'comment' => $existingBooking->comment,
                        ]);
                        $existingBooking->delete(); // Delete the old booking
                    }
                    break;
            }
        }

        // Allow the request to proceed if no constraints are violated
        return $next($request);
    }
}
