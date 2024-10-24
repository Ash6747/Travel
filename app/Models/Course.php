<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = "courses";
    protected $primaryKey = "id";

    // Add the fields that you want to allow mass assignment for
    protected $fillable = [
        'coures_full_name',
        'coures_short_name',
        'coures_code',
        'coures_years',
    ];

    // Relationship with Student
    public function students()
    {
        return $this->hasMany(Student::class, 'course_id');
    }
}
