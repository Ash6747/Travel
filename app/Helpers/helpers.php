<?php

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

if (!function_exists('isSiteAccessible')) {
    function isSiteAccessible()
    {
        $settings = DB::table('settings')->first();

        return $settings && $settings->status &&
               (is_null($settings->expiration_date) ||
               Carbon::now()->lte(Carbon::parse($settings->expiration_date)));
    }
}
