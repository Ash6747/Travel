<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BookingsExport;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'stop'])->get();
        // dd($bookings);

        $status = 'all';
        $data = compact('bookings', 'status');
        return view('admin.booking.bookings')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function filter(Request $request)
    {
        // dd($request);
        $today = Carbon::today();
        $status = $request->query('status');
        $fdate = $request->query('fdate');
        $tdate = $request->query('tdate');

        // Filter based on status
        $query = Booking::with(['student', 'bus' => function($query) {
            $query->with('route');
        }, 'stop']);

        switch ($status) {
            case 'all':
                // $bookings = $query;
                break;

            case 'active':
                $query->where('status', 'approved')->where('end_date', '>', $today);
                break;

            case 'expired':
                $query->where('status', 'approved')->where('end_date', '<', $today);
                break;

            default:
                $query->where('status', $status);
                break;
        }

        if($fdate){
            $query->where('created_at', '>=', $fdate);
        }

        if($tdate){
            $query->where('created_at', '<=', $tdate);
        }

        $bookings = $query->get();

        $data = compact('bookings', 'status', 'fdate', 'tdate');
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

    public function export(Request $request)
    {
        $today = Carbon::today();
        $status = $request->query('status');
        $fdate = $request->query('fdate');
        $tdate = $request->query('tdate');

        // Filter based on status
        $query = Booking::with(['student', 'bus' => function($query) {
            $query->with('route');
        }, 'stop']);

        // if (is_null($status)) {
        //     $bookings = $query->get(); // Default to all bookings if null status is provided
        // } elseif ($status === 'active') {
        //     $bookings = $query->where('status', 'approved')->where('end_date', '>', $today)->get();
        // } elseif ($status === 'expired') {
        //     $bookings = $query->where('status', 'approved')->where('end_date', '<', $today)->get();
        // } else {
        //     $bookings = $query->where('status', $status)->get();
        // }
        // $status = all;
        switch ($status) {
            case 'all':
                // $bookings = $query;
                break;

            case 'active':
                $query->where('status', 'approved')->where('end_date', '>', $today);
                break;

            case 'expired':
                $query->where('status', 'approved')->where('end_date', '<', $today);
                break;

            default:
                $query->where('status', $status);
                break;
        }

        if($fdate){
            $query->where('created_at', '>=', $fdate);
        }

        if($tdate){
            $query->where('created_at', '<=', $tdate);
        }

        $bookings = $query->get();

        // $data = compact('bookings', 'status', 'fdate', 'tdate');

        return Excel::download(new BookingsExport($bookings), 'bookings.xlsx');
    }

    public function pdf(string $id){

        $booking = Booking::with(['student'=> function($query){
            $query->with(['user', 'course', 'reports']);
        }, 'bus'=> function($query){
            $query->with('route');
        }, 'stop', 'transactions'])->findOrFail($id);

        $url = 'booking.update';
        $title = "Booking";
        $routTitle = "Update";
        $data = compact('url', 'title', 'booking', 'routTitle', 'id');
        // resources\views\admin\transaction\transactionPdf.blade.php
        $pdf = Pdf::loadView('admin.booking.bookingPdf', $data);
        return $pdf->download('booking.pdf');
    }
}
