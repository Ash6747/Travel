<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cancel_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // Foreign key
            $table->unsignedBigInteger('booking_id')->unique(); // Foreign key
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->text('reason');
            $table->text('resolution')->nullable();
            $table->string('file')->nullable()->comment('add any file that satisfy the reason');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // Foreign key constraint for student_id
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('trip_id')->references('id')->on('trips');
            $table->foreign('bus_id')->references('id')->on('buses');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('verified_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_bookings');
    }
};
