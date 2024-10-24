<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = "admins";
    protected $primaryKey = "id";

    // Add the fields that you want to allow mass assignment for
    protected $fillable = [
        'profile',
        'full_name',
        'contact',
        'whatsup_no',
        'identity_number',
        'identity_file',
        'user_id',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'verified_by');
    }
}
