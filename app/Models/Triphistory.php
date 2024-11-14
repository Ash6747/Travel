<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Triphistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_meter_img',
        'start_meter_reading',

        'end_meter_img',
        'end_meter_reading',

        'latitude',
        'longitude',

        'distance_traveled',
        'phase',
        'status',

        'trip_id',
        'driver_id',
    ];

    public function trip(){
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
