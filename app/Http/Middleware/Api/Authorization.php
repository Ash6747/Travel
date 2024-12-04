<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $user = Auth::user();
        $user = Auth::guard('api')->user();
        $url = $request->fullUrl();
        // dd($user);
        // dd($user);
        // Check if the user is authenticated
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ],400);
        }


        // Get the user role and the current route prefix
        $userRole = $user->role;
        $routePrefix = explode('/', $request->path())[1]; // Get the first prefix (admin, student, driver, guardian)

        // Check if the user role matches the route prefix
        if ($userRole !== $routePrefix) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ],400);
        }
        $request->merge(['user_id' => $user->id]);
        return $next($request);
    }
}
