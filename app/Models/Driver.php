<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $table = "drivers";
    protected $primaryKey = "id";

    // public function setDriverNameAttribute($val){
    //     $this->attributes['driver_name'] = ucwords(strtolower($val)); //ucfirst(strtolower($val));
    // }

    // public function getDriverNameAttribute($value){
    //     return ucwords(strtolower($value)); // ucfirst(strtolower($value));
    // }

    // Add the fields that you want to allow mass assignment for
    protected $fillable = [
        'profile',
        'full_name',
        'contact',
        'whatsup_no',
        'license_number',
        'license_exp',
        'license_file',
        'address',
        'pincode',
        'user_id',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trip()
    {
        return $this->hasOne(Trip::class, 'driver_id');
    }

    public function triphistories(){
        return $this->hasMany(Triphistory::class, 'driver_id');
    }

    public function leaves(){
        return $this->hasMany(Driverleave::class, 'driver_id');
    }

    public function complaints(){
        return $this->hasMany(Complaint::class, 'driver_id');
    }

}
