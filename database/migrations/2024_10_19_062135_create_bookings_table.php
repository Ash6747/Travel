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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('duration', [1, 6, 12]);
            $table->decimal('fee', 8, 2);
            $table->enum('class', ['First', 'Second', 'Third', 'Forth', 'Fifth', 'Sixth', 'Seventh']);
            $table->string('current_academic_year', 10);

            $table->decimal('total_amount', 8, 2)->default(0.00);
            $table->decimal('refund', 8, 2)->nullable();
            $table->enum('payment_status' ,['Partially', 'Full', 'Not', 'Concession'])->default('Not');
            $table->tinyInteger('remaining_amount_check')->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('comment')->nullable();

            $table->unsignedBigInteger('verified_by')->nullable()->comment('admin id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('stop_id');

            $table->foreign('verified_by')->references('id')->on('admins');

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('bus_id')->references('id')->on('buses');
            $table->foreign('stop_id')->references('id')->on('stops');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
