<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = "students";
    protected $primaryKey = "id";

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function bookings()
    {
        return $this->hasOne(Booking::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'student_id');
    }

}
