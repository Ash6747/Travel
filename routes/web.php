<?php

use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoutesController;
use App\Http\Controllers\Admin\StopsController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// student

Route::prefix('student')->middleware(['auth', 'verified', 'student', 'check.student.profile'])->group(function(){

    Route::get('dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
});

// admin
Route::prefix('admin')->middleware(['auth', 'verified', 'admin', 'check.admin.profile'])->group(function(){
    Route::get('dashboard', [AdminProfileController::class, 'index'])->name('admin.dashboard');
    Route::get('profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('profile', [AdminProfileController::class, 'destroy'])->name('admin.profile.destroy');

    //Admin Driver Controller
    Route::prefix('drivers')->controller(DriverController::class)->group(function () {
        Route::get('/', 'index')->name('driver.table');
        Route::get('/unregistered', 'unregistered')->name('driver.unregistered');

        // Route::get('/trash', 'trash')->name('driver.trash');
        // Route::get('/restore/{id}', 'restore')->name('driver.restore');
        // Route::get('/force-delete/{id}', 'forcefullyDelete')->name('driver.hardDelete');

        Route::get('/status/{id}', 'active')->name('driver.status');
        // Route::get('/delete/{id}', 'destroy')->name('driver.delete');

        Route::get('/create/{id}', 'create')->name('driver.create');
        Route::post('/create/{id}', 'store')->name('driver.store');

        Route::get('/update/{id}', 'edit')->name('driver.edit');
        Route::post('/update/{id}', 'update')->name('driver.update');
    });

    //Admin Route Controller
    Route::prefix('routes')->controller(RoutesController::class)->group(function () {
        Route::get('/', 'index')->name('route.table');

        // Route::get('/trash', 'trash')->name('route.trash');
        // Route::get('/restore/{id}', 'restore')->name('route.restore');
        // Route::get('/force-delete/{id}', 'forcefullyDelete')->name('route.hardDelete');

        Route::get('/status/{id}', 'active')->name('route.status');
        // Route::get('/delete/{id}', 'destroy')->name('route.delete');

        Route::get('/stops/{id}', 'show')->name('route.stops');
        Route::post('/stops/{id}', 'add')->name('route.add');
        Route::post('/stops/{id}/{stopId}', 'sync')->name('route.sync');
        Route::get('/stops/{id}/{stopId}', 'detach')->name('route.detach');

        Route::get('/create', 'create')->name('route.create');
        Route::post('/create', 'store')->name('route.store');

        Route::get('/update/{id}', 'edit')->name('route.edit');
        Route::post('/update/{id}', 'update')->name('route.update');
    });

    //Admin Buses Controller
    Route::prefix('buses')->controller(BusController::class)->group(function () {
        Route::get('/', 'index')->name('bus.table');
        Route::get('active', 'enabled')->name('bus.enabled');
        Route::get('inactive', 'disabled')->name('bus.disabled');

        Route::get('export','export')->name('bus.export');

        // Route::get('/trash', 'trash')->name('bus.trash');
        // Route::get('/restore/{id}', 'restore')->name('bus.restore');
        // Route::get('/force-delete/{id}', 'forcefullyDelete')->name('bus.hardDelete');

        Route::get('/status/{id}', 'active')->name('bus.status');
        // Route::get('/delete/{id}', 'destroy')->name('route.delete');

        Route::get('/create', 'create')->name('bus.create');
        Route::post('/create', 'store')->name('bus.store');

        Route::get('/update/{id}', 'edit')->name('bus.edit');
        Route::post('/update/{id}', 'update')->name('bus.update');
    });

    //Admin Stops Controller
    Route::prefix('stops')->controller(StopsController::class)->group(function () {
        Route::get('/', 'index')->name('stop.table');

        // Route::get('/trash', 'trash')->name('stop.trash');
        // Route::get('/restore/{id}', 'restore')->name('stop.restore');
        // Route::get('/force-delete/{id}', 'forcefullyDelete')->name('stop.hardDelete');

        Route::get('/status/{id}', 'active')->name('stop.status');
        // Route::get('/delete/{id}', 'destroy')->name('route.delete');

        Route::get('/create', 'create')->name('stop.create');
        Route::post('/create', 'store')->name('stop.store');

        Route::get('/update/{id}', 'edit')->name('stop.edit');
        Route::post('/update/{id}', 'update')->name('stop.update');
    });

    //Admin Course Controller
    Route::prefix('course')->controller(CourseController::class)->group(function () {
        Route::get('/', 'index')->name('course.table');

        // Route::get('/trash', 'trash')->name('course.trash');
        // Route::get('/restore/{id}', 'restore')->name('course.restore');
        // Route::get('/force-delete/{id}', 'forcefullyDelete')->name('course.hardDelete');

        Route::get('/status/{id}', 'active')->name('course.status');
        // Route::get('/delete/{id}', 'destroy')->name('route.delete');

        Route::get('/create', 'create')->name('course.create');
        Route::post('/create', 'store')->name('course.store');

        Route::get('/update/{id}', 'edit')->name('course.edit');
        Route::post('/update/{id}', 'update')->name('course.update');
    });

    //Admin Booking Controller
    Route::prefix('booking')->controller(BookingController::class)->group(function () {
        Route::get('/', 'index')->name('booking.table');
        // Route::get('/approved', 'index')->name('booking.approved');
        Route::get('pending', 'pending')->name('booking.pending');
        Route::get('approved', 'active')->name('booking.active');
        Route::get('rejected', 'rejected')->name('booking.rejected');
        Route::get('expired', 'expired')->name('booking.expired');

        Route::get('export','export')->name('bookings.export');
        Route::get('pdf/{id}','pdf')->name('bookings.pdf');

        // Route::get('/trash', 'trash')->name('booking.trash');
        // Route::get('/restore/{id}', 'restore')->name('booking.restore');
        // Route::get('/force-delete/{id}', 'forcefullyDelete')->name('booking.hardDelete');

        Route::get('status/{id}', 'active')->name('booking.status');
        // Route::get('/delete/{id}', 'destroy')->name('route.delete');

        Route::get('create', 'create')->name('booking.create');
        Route::post('create', 'store')->name('booking.store');

        Route::get('update/{id}', 'edit')->name('booking.edit');
        Route::post('update/{id}', 'update')->name('booking.update')->middleware('bus.constraint');
    });

    //Admin transactions Controller
    Route::prefix('transactions')->controller(TransactionController::class)->group(function () {
        Route::get('/', 'index')->name('transaction.table');
        Route::get('pending', 'pending')->name('transaction.pending');
        Route::get('approved', 'accepted')->name('transaction.accepted');
        Route::get('rejected', 'rejected')->name('transaction.rejected');

        Route::get('export','export')->name('transaction.export');
        Route::get('pdf/{id}','pdf')->name('transaction.pdf');

        // Route::get('/trash', 'trash')->name('transaction.trash');
        // Route::get('/restore/{id}', 'restore')->name('transaction.restore');
        // Route::get('/force-delete/{id}', 'forcefullyDelete')->name('transaction.hardDelete');

        Route::get('/status/{id}', 'active')->name('transaction.status');
        // Route::get('/delete/{id}', 'destroy')->name('route.delete');

        Route::get('/create', 'create')->name('transaction.create');
        Route::post('/create', 'store')->name('transaction.store');

        Route::get('/update/{id}', 'edit')->name('transaction.edit');
        Route::post('/update/{id}', 'update')->name('transaction.update');
    });

    //Admin trips Controller
    Route::prefix('trips')->controller(TripController::class)->group(function () {
        Route::get('/', 'index')->name('trip.table');
        Route::get('active', 'enabled')->name('trip.enabled');
        Route::get('inactive', 'disabled')->name('trip.disabled');

        Route::get('export','export')->name('trip.export');
        // Route::get('pdf/{id}','pdf')->name('trip.pdf');

        Route::get('/status/{id}', 'status')->name('trip.status');

        Route::get('/create', 'create')->name('trip.create');
        Route::post('/create', 'store')->name('trip.store');

        Route::get('/update/{id}', 'edit')->name('trip.edit');
        Route::post('/update/{id}', 'update')->name('trip.update');
    });
    //Admin triphistory Controller
    Route::prefix('triphistory')->controller(TripController::class)->group(function () {
        Route::get('/', 'index')->name('triphistory.table');
        // Route::get('active', 'enabled')->name('triphistory.enabled');
        // Route::get('inactive', 'disabled')->name('triphistory.disabled');

        // Route::get('export','export')->name('triphistory.export');
        // Route::get('pdf/{id}','pdf')->name('triphistory.pdf');

        // Route::get('/status/{id}', 'status')->name('triphistory.status');

        // Route::get('/create', 'create')->name('triphistory.create');
        // Route::post('/create', 'store')->name('triphistory.store');

        // Route::get('/update/{id}', 'edit')->name('triphistory.edit');
        // Route::post('/update/{id}', 'update')->name('triphistory.update');
    });

    //Admin Students Controller
    Route::prefix('students')->controller(ReportController::class)->group(function () {
        Route::get('/', 'index')->name('student.table');

        // Route::get('/trash', 'trash')->name('transaction.trash');
        // Route::get('/restore/{id}', 'restore')->name('transaction.restore');
        // Route::get('/force-delete/{id}', 'forcefullyDelete')->name('transaction.hardDelete');

        Route::get('/status/{id}', 'active')->name('student.status');
        // Route::get('/delete/{id}', 'destroy')->name('route.delete');

        Route::get('/create', 'create')->name('student.create');
        Route::post('/create', 'store')->name('student.store');

        Route::get('/update/{id}', 'edit')->name('student.edit');
        Route::post('/update/{id}', 'update')->name('student.update');
    });
});
// driver
Route::prefix('driver')->middleware(['auth', 'verified', 'driver'])->group(function(){
    Route::get('dashboard', function () {
        return view('driver.dashboard');
    })->name('driver.dashboard');

});
Route::get('complete-profile/{id}', [ProfileController::class, 'showCompleteProfile'])->name('complete-profile');
Route::post('complete-profile/{id}', [ProfileController::class, 'completeProfile'])->name('complete-profile');
// guardian
Route::prefix('guardian')->middleware(['auth', 'verified', 'guardian'])->group(function(){
    Route::get('dashboard', function () {
        return view('guardian.dashboard');
    })->name('guardian.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
