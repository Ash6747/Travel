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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->time('expected_morning_start_time');
            $table->time('expected_morning_end_time');
            $table->time('expected_evening_start_time');
            $table->time('expected_evening_end_time');

            $table->decimal('expected_distance', 4, 2);
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('driver_id');

            $table->foreign('bus_id')->references('id')->on('buses');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
