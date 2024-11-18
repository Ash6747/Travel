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
        Schema::create('triphistories', function (Blueprint $table) {
            $table->id();
            $table->string('start_meter_img');
            $table->string('end_meter_img')->nullable();

            $table->decimal('start_meter_reading', 10, 2);       // Bus starting meter reading
            $table->decimal('end_meter_reading', 10, 2)->nullable();       // Bus ending meter reading

            $table->decimal('latitude', 10, 7)->nullable(); // Precision for GPS coordinates
            $table->decimal('longitude', 10, 7)->nullable(); // Precision for GPS coordinates

            $table->decimal('distance_traveled', 10, 2)->nullable();
            $table->text('note', 250)->nullable();

            $table->enum('status', ['active', 'complete', 'cancle'])->default('active');
            $table->tinyInteger('phase');

            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('driver_id');

            $table->foreign('trip_id')->references('id')->on('trips');
            $table->foreign('driver_id')->references('id')->on('drivers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('triphistories');
    }
};
