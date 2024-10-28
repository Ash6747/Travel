<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Add the fields that you want to allow mass assignment for
    protected $fillable = [
        //get from student
        'payment_date',
        'reciept_token',
        'paid_amount',
        'reciept_file',
        'pay_type',

        // calculated
        'paid_status',

        // get from auth-api
        'student_id',
        'booking_id',

        // updated by admin
        'payment_date_check',
        'reciept_token_check',
        'paid_amount_check',
        'reciept_file_check',
        'pay_type_check',
        'student_detail_check',
        'comment',

        'status',//depends on all checks are true
        // get by auth
        'verified_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    // Inverse of the relationship with reports
    public function report()
    {
        return $this->belongsTo(Report::class, 'booking_id', 'booking_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }
}
