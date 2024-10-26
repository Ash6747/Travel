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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date');
            $table->string('reciept_token', 30);
            $table->decimal('paid_amount', 8, 2);
            $table->string('reciept_file');
            $table->enum('pay_type', ['dd', 'cash', 'cheque', 'bank transfer', 'nft', 'upi']);
            $table->enum('paid_status', ['full', 'partial']);

            $table->tinyInteger('payment_date_check')->default(0);
            $table->tinyInteger('reciept_token_check')->default(0);
            $table->tinyInteger('paid_amount_check')->default(0);
            $table->tinyInteger('reciept_file_check')->default(0);
            $table->tinyInteger('pay_type_check')->default(0);
            $table->tinyInteger('student_detail_check')->default(0);

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('verified_by')->nullable()->comment('admin id');
            $table->text('comment', 200)->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected']);

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('verified_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
