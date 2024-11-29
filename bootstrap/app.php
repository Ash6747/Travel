<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Admin\BusLimitCheck;
use App\Http\Middleware\Admin\CheckAdminProfile;
use App\Http\Middleware\Api\ApiAuthenticate;
use App\Http\Middleware\Api\Authorization;
use App\Http\Middleware\Api\BusCapacityCheck;
use App\Http\Middleware\Api\CheckBookingExist;
use App\Http\Middleware\Api\CheckBookingExpired;
use App\Http\Middleware\Api\CheckDriverExist;
use App\Http\Middleware\Api\CheckStudentExist;
use App\Http\Middleware\Api\CheckTripExist;
use App\Http\Middleware\Api\Handletoken;
use App\Http\Middleware\BookingConstraintMiddleware;
use App\Http\Middleware\CheckDriverProfile;
use App\Http\Middleware\Driver;
use App\Http\Middleware\Guardian;
use App\Http\Middleware\Student;
use App\Http\Middleware\Student\CheckStudentProfile;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'=>Admin::class,
            'student'=>Student::class,
            'driver'=>Driver::class,
            'guardian'=>Guardian::class,
            'api.auth' => ApiAuthenticate::class,
            'checkBearer'=>Handletoken::class,
            'check.driver.profile' => CheckDriverProfile::class,
            'check.student.profile' => CheckStudentProfile::class,
            'check.admin.profile' => CheckAdminProfile::class,
            'authorized'=>Authorization::class,
            // Other middleware Api
            'booking.constraint'=>BookingConstraintMiddleware::class,
            'booking.exist'=>CheckBookingExist::class,
            'booking.expired'=>CheckBookingExpired::class,
            'bus.constraint'=>BusLimitCheck::class,
            'bus.capacity'=>BusCapacityCheck::class,
            'check.api.student.profile'=>CheckStudentExist::class,
            'check.api.driver.profile'=>CheckDriverExist::class,
            'trip.exist'=>CheckTripExist::class,
            // Excel
            'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
