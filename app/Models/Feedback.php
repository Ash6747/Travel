<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Add the fields that you want to allow mass assignment for
    protected $fillable = [
        'trip_id',
        'bus_id',
        'driver_id',
        'student_id',
        'booking_id',

        'question_1',
        'question_2',
        'question_3',
        'question_4',
        'question_5',
        'question_6',
        'question_7',
        'question_8',
        'question_9',
        'question_10',
        'question_11',
        'question_12',
        'question_13',
        'question_14',
        'question_15',
        'message',
    ];

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relationship with Student
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    // Relationship with Bus
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    // Relationship with Trip
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    // Relationship with Trip
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}

