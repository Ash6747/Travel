<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = "reports";
    protected $primaryKey = "id";

    // Add the fields that you want to allow mass assignment for
    protected $fillable = [
        'student_id',
        'bus_id',
        'stop_id',
        'old_booking_id',

        'start_date',
        'end_date',
        'duration',
        'fee',
        'class',
        'current_academic_year',

        // admin
        'total_amount',
        'refund',
        'verified_by',
        'payment_status',
        'remaining_amount_check',
        'status',
        'comment',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    public function stop()
    {
        return $this->belongsTo(Stop::class, 'stop_id');
    }

    // One-to-Many relationship with transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'booking_id', 'booking_id');
    }
}
