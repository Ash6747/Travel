<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driverleave extends Model
{
    use HasFactory;

    protected $fillable = [
        'reason',
        'driver_id',
        'start_date',
        'end_date',
        'duration',
    ];

    public function driver(){
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
