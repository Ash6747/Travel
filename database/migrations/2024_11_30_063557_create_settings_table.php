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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->boolean('status')->default(true); //Active/Inactive
            $table->timestamp('expiration_date'); // Plan expiration date for settings
            $table->boolean('sms')->default(false); // sms enabled/disabled
            $table->boolean('advertisement')->default(true); //Advertisement enabled/disabled
            $table->boolean('notice')->default(false); //Notice enabled/disabled
            $table->timestamps();// created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
