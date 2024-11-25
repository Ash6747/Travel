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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('driver_id');
            $table->text('details');
            $table->text('resolution')->nullable();
            $table->string('complaint_file')->nullable();
            $table->enum('status', ['pending', 'progress', 'resolved'])->default('pending');
            $table->timestamps();

            // Foreinkey constrain
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('trip_id')->references('id')->on('trips');
            $table->foreign('bus_id')->references('id')->on('buses');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('verified_by')->references('id')->on('admins');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
