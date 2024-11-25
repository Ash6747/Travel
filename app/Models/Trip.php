<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    // Accesor to access time with removed seconds
    public function getExpectedMorningStartTimeAttribute($val){
        return Carbon::createFromFormat('H:i:s', $val)->format('H:i');
    }
    public function getExpectedMorningEndTimeAttribute($val){
        return Carbon::createFromFormat('H:i:s', $val)->format('H:i');
    }
    public function getExpectedEveningStartTimeAttribute($val){
        return Carbon::createFromFormat('H:i:s', $val)->format('H:i');
    }
    public function getExpectedEveningEndTimeAttribute($val){
        return Carbon::createFromFormat('H:i:s', $val)->format('H:i');
    }

    // Add the fields that you want to allow mass assignment for
    protected $fillable = [
        'bus_id',
        'driver_id',
        'expected_morning_start_time',
        'expected_morning_end_time',
        'expected_evening_start_time',
        'expected_evening_end_time',
        'expected_distance',
        'status',
    ];

    public function bus(){
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    public function driver(){
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function triphistories(){
        return $this->hasMany(Triphistory::class, 'trip_id');
    }

    public function complaints(){
        return $this->hasMany(Complaint::class, 'trip_id');
    }
}
