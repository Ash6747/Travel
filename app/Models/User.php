<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Automatically load the related model based on the role
    protected $with = [];

    // Relationship with Admin
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    // Relationship with Driver
    public function driver()
    {
        return $this->hasOne(Driver::class, 'user_id');
    }

    // Relationship with Student
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    /**
     * Load the related model based on the user's role.
     *
     * @return \App\Models\Admin|\App\Models\Driver|\App\Models\Student|null
     */

    public function loadRelatedModel()
    {
        if ($this->role === 'admin') {
            return $this->admin;
        } elseif ($this->role === 'driver') {
            return $this->driver;
        } elseif ($this->role === 'student') {
            return $this->student;
        }

        return null; // If the role is none of the expected values
    }

}
