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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('profile')->nullable();
            $table->string('full_name');
            $table->string('contact', 15)->unique();
            $table->string('whatsup_no', 15)->unique()->nullable();
            $table->string('license_file');
            $table->string('license_number', 50)->unique();
            $table->date('license_exp');
            $table->text('address');
            $table->string('pincode', 6);  // Removed auto_increment and primary key from pincode
            $table->tinyInteger('status')->default(0);  // Tinyint(1) with default value 0
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
