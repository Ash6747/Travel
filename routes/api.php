<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BusController;
use App\Http\Controllers\Api\CoursesController;
use App\Http\Controllers\Api\RoutesController;
use App\Http\Controllers\Api\StopsController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\TriphistoryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::get('/', function () {
    return "hello world";
});

Route::post('/register', [UserController::class, 'register'] );
Route::post('/login', [UserController::class, 'login'] );
Route::middleware(['checkBearer', 'api.auth'])->group(function(){

    // Bus
    Route::prefix('stop')->group(function(){
        Route::get('/', [StopsController::class, 'index'] );
        Route::get('{id}/routes', [StopsController::class, 'show'] );
        Route::get('routes/{id}/buses', [RoutesController::class, 'show']);

        Route::get('{id}/buses', [StopsController::class, 'buses'] );//return only active bus with no constrain
        Route::get('{id}/stop-buses', [BusController::class, 'show'] );//active with constrain
    });

    // admin
    Route::prefix('admin')->middleware('authorized')->group(function(){
        Route::get('users', [UserController::class, 'getUser'] );
    });

    // student
    Route::prefix('student')->middleware(['authorized', 'check.api.student.profile'])->group(function(){

        // Route::get('class', [CoursesController::class, 'index'] );
        Route::get('/details', [UserController::class, 'index'] );
        Route::get('users', [UserController::class, 'getUser'] );

        // Booking
        Route::prefix('bookings')->controller(BookingController::class)->group(function(){
            Route::get('/', 'index' );
            Route::get('history', 'history' );
            Route::get('history/{id}', 'show' );
            Route::post('create', 'createOrUpdateBooking' )->middleware('booking.constraint');

        });

        // transaction
        Route::prefix('transactions')->controller(TransactionController::class)->group(function(){
            Route::get('/', 'index' );
            Route::get('show/{id}',  'show' );
            Route::post('make','store' )->middleware('booking.exist');

        });

    });

    // driver
    Route::prefix('driver')->middleware('authorized')->group(function(){
        Route::get('users', [UserController::class, 'getUser'] );

        Route::prefix('trip')->controller(TripController::class)->group(function(){
            Route::get('/', 'index');
        });

        Route::prefix('triphistory')->controller(TriphistoryController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/end','update' );
            Route::post('/location','location' );
            Route::post('/store','store' );

            Route::get('show/{id}',  'show' );
        });
    });

    // guardian
    Route::prefix('guardian')->middleware('authorized')->group(function(){
        Route::get('users', [UserController::class, 'getUser'] );
    });

    Route::get('/logout', [UserController::class, 'logout'] );

});

// Fallback route for API
Route::fallback(function () {
    return response()->json([
        'status' => false,
        'message' => 'Route not found',
    ],404);
});
