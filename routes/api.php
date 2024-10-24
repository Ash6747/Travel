<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BusController;
use App\Http\Controllers\Api\CoursesController;
use App\Http\Controllers\Api\RoutesController;
use App\Http\Controllers\Api\StopsController;
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

    Route::prefix('admin')->middleware('authorized')->group(function(){
        Route::get('users', [UserController::class, 'getUser'] );
    });
    Route::prefix('student')->middleware('authorized')->group(function(){

        Route::get('users', [UserController::class, 'getUser'] );
        // Route::get('class', [CoursesController::class, 'index'] );

        // Booking
        // Route::post('book', [BookingController::class, 'store'] );
        Route::post('booking', [BookingController::class, 'createOrUpdateBooking'] )->middleware('booking.constraint');

    });
    Route::prefix('driver')->middleware('authorized')->group(function(){
        Route::get('users', [UserController::class, 'getUser'] );
    });
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
