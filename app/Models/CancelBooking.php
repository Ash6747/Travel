<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelBooking extends Model
{
    use HasFactory;


    protected $fillable = [
        'student_id',
        'booking_id',
        'trip_id',
        'bus_id',
        'driver_id',
        'verified_by',

        'reason',
        'file',

        'resolution',
        'status',
    ];

    // Relationship with Driver
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    // Relationship with Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    // Inverse of the relationship with reports
    public function report()
    {
        return $this->belongsTo(Report::class, 'booking_id', 'booking_id');
    }

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relationship with Trip
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    // Relationship with Bus
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    // Relationship with Student
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

}
