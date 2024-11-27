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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // Foreign key
            $table->unsignedBigInteger('booking_id'); // Foreign key
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('driver_id');
            $table->enum('question_1', ['Very easy', 'Somewhat easy', 'Neutral', 'Somewhat difficult', 'Very difficult']);
            $table->enum('question_2', ['Very clear', 'Mostly clear', 'Neutral', 'Somewhat unclear', 'Very unclear']);
            $table->enum('question_3', ['Very satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very dissatisfied']);
            $table->enum('question_4', ['Excellent', 'Good', 'Average', 'Below average', 'Poor']);
            $table->enum('question_5', ['Very accurate', 'Mostly accurate', 'Neutral', 'Somewhat inaccurate', 'Very inaccurate']);
            $table->enum('question_6', ['Very convenient', 'Convenient', 'Neutral', 'Inconvenient', 'Very inconvenient']);
            $table->enum('question_7', ['Excellent', 'Good', 'Average', 'Below average', 'Poor']);
            $table->enum('question_8', ['Very likely', 'Likely', 'Neutral', 'Unlikely', 'Very unlikely']);
            $table->enum('question_9', ['Never', 'Rarely', 'Sometimes', 'Often', 'Always']);
            $table->enum('question_10', ['Very easy', 'Easy', 'Neutral', 'Difficult', 'Very difficult']);
            $table->enum('question_11', ['Very satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very dissatisfied']);
            $table->enum('question_12', ['Very clear', 'Mostly clear', 'Neutral', 'Somewhat unclear', 'Very unclear']);
            $table->enum('question_13', ['Very responsive', 'Responsive', 'Neutral', 'Slow response', 'No response']);
            $table->enum('question_14', ['Very fast', 'Fast', 'Average', 'Slow', 'Very slow']);
            $table->enum('question_15', ['Very satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very dissatisfied']);
            $table->text('message', 250)->nullable(); // Automatically set the submission time

            // Foreign key constraint for student_id
            $table->foreign('trip_id')->references('id')->on('trips');
            $table->foreign('bus_id')->references('id')->on('buses');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
