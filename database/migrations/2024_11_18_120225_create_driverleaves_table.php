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
        Schema::create('driverleaves', function (Blueprint $table) {
            $table->id();
            $table->text('reason', 250);
            $table->decimal('duration', 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('driver_id');

            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driverleaves');
    }
};