<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $table = "buses";
    protected $primaryKey = "id";

    // Add the fields that you want to allow mass assignment for
    protected $fillable = [
        'bus_no',
        'capacity',
        'route_id',
    ];

    // Inverse relationship: A bus belongs to a route
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function trip()
    {
        return $this->hasOne(Trip::class, 'bus_id');
    }


    public function complaints(){
        return $this->hasMany(Complaint::class, 'bus_id');
    }


    public function feedbacks(){
        return $this->hasMany(Feedback::class, 'bus_id');
    }

    public function cancel(){
        return $this->hasMany(CancelBooking::class, 'bus_id');
    }
}
