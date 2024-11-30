<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckSiteAccessibility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = DB::table('settings')->first(); //Assuming only one setting row exists

        if(!$settings){
            abort(503, 'Site settings not configured');
        }

        // Check if the site is active and not expired
        $isAccessible = $settings->status &&
                        (is_null($settings->expiration_date) ||
                        Carbon::now()->lte(Carbon::parse($settings->expiration_date)));

        if(!$isAccessible){
            return response()->view('errors.site_inaccessible', [], 403);
        }
        return $next($request);
    }
}
