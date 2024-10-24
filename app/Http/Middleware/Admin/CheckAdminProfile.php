<?php

namespace App\Http\Middleware\Admin;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $userId = Auth::id();

            // Check if the user's ID exists in the drivers table
            $driver = Admin::where('user_id', $userId)->first();

            if (!$driver) {
                // If the user does not exist in the drivers table, redirect to complete-profile page
                return redirect()->route('complete-profile', ['id'=> $userId]);
            }
        }
        return $next($request);
    }
}
