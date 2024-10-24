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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('profile')->nullable();
            $table->string('full_name');
            $table->date('dob');
            $table->string('prn', 20)->unique();
            $table->string('contact', 15);
            $table->string('whatsup_no', 15)->nullable();
            $table->unsignedBigInteger('course_id');
            $table->string('admission_year', 4);
            $table->string('guardian_name');
            $table->string('guardian_email', 30)->nullable();
            $table->string('guardian_contact', 15);
            $table->text('address');
            $table->string('pincode', 6);
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
