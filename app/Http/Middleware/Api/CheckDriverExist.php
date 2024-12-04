<?php

namespace App\Http\Middleware\Api;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDriverExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::with('driver')->findOrFail($request->user_id);

        if (!$user->driver) {
            return response()->json([
                'status' => false,
                'message' => 'Driver ID not found for authenticated user.',
            ], 400);
        }

        $request->merge(['driver_id' => $user->driver->id]);

        return $next($request);
    }
}
