<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;
    protected $table = "Stops";
    protected $primaryKey = "id";

    // // A stop belongs to one route
    // public function route()
    // {
    //     return $this->belongsTo(Route::class, 'route_id');
    // }

    public function routes(){
        return $this->belongsToMany(Route::class, 'route_stops')
        ->withPivot('stop_order')  // Include the 'order' column from pivot table
        ->orderBy('stop_order');  // Sort by the 'order' column
    }

    // Add the fields that you want to allow mass assignment for
    protected $fillable = [
        'stop_name',
        'longitude',
        'latitude',
        'fee',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
