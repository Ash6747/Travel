<?php

namespace App\Http\Middleware\Api;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $student = User::with('student')->findOrFail($request->user_id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student ID not found for authenticated user.',
            ], 400);
        }

        $request->merge(['student_id' => $student->student->id]);

        return $next($request);
    }
}
