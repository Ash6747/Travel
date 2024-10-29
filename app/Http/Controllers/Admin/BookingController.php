<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bookings = Booking::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'stop'])->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $data = compact('bookings');
        return view('admin.booking.bookings')->with($data);
    }

    public function pending()
    {
        //
        $bookings = Booking::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'stop'])->where('status', 'pending')->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $data = compact('bookings');
        return view('admin.booking.bookings')->with($data);
    }

    public function active()
    {
        //
        $today = Carbon::today();
        $bookings = Booking::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'stop'])
        ->where('status', 'approved')
        ->where('end_date', '>', $today)
        ->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $data = compact('bookings');
        return view('admin.booking.bookings')->with($data);
    }

    public function rejected()
    {
        //
        $bookings = Booking::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'stop'])->where('status', 'rejected')->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $data = compact('bookings');
        return view('admin.booking.bookings')->with($data);
    }

    public function expired()
    {
        //
        $today = Carbon::today(); // Current date without time

        $bookings = Booking::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'stop'])->where('end_date', '<', $today)
        ->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $data = compact('bookings');
        return view('admin.booking.bookings')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $booking = Booking::with(['student'=> function($query){
            $query->with(['user', 'course', 'reports']);
        }, 'bus'=> function($query){
            $query->with('route');
        }, 'stop', 'transactions'])->findOrFail($id);

        // dd($route);
        if (is_null($booking)) {
            return redirect('bookings');
        } else {
            $url = 'booking.update';
            $title = "Booking Update";
            $routTitle = "Update";
            $data = compact('url', 'title', 'booking', 'routTitle', 'id');
            return view('admin.booking.form')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $booking = Booking::find($id);
        $validatedData = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
        ]);
        // echo "<pre>";
        // print_r($booking);
        if (is_null($booking)) {
            return redirect()->route('booking.table');
        } else {
            $booking->status = $request->status;
            $booking->save();
            return redirect()->route('booking.table');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
