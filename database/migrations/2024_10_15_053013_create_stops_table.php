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
        Schema::create('stops', function (Blueprint $table) {
            $table->id();
            $table->string('stop_name', 100); // Stop name with max 100 characters
            $table->decimal('longitude', 10, 7); // Longitude: -180 to 180 with precision up to 7 decimals
            $table->decimal('latitude', 9, 7); // Latitude: -90 to 90 with precision up to 7 decimals
            $table->decimal('fee', 8, 2); // Fee with up to 8 digits and 2 decimals
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stops');
    }
};
