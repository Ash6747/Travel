<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

     // Add the fields that you want to allow mass assignment for
     protected $fillable = [
        'verified_by',
        'student_id',
        'trip_id',
        'bus_id',
        'driver_id',
        'details',
        'resolution',
        'complaint_file',
        'status',
    ];

    // Relationship with admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

      // Relationship with Trips
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    // Relationship with Bus
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

      // Relationship with Driver
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
