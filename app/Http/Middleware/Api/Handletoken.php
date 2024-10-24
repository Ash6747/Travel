<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\json;

class Handletoken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the Authorization header is present
        $authHeader = $request->header('Authorization');

        // Check if the Bearer token is present
        if (is_null($authHeader) || !preg_match('/^Bearer\s+(\S+)$/', $authHeader)) {
            // Return a 401 Unauthorized response if the Bearer token is not present
            return response()->json(['error' => 'Bearer token is required'], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
