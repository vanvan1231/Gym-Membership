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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('member_id');
            $table->double('amount');
            $table->enum('payment_type', ['cash', 'gcash']);
            $table->enum('payment_for', [
                'annual_fee',
                'sub_monthly',
                'sub_yearly',
                'sub_quarterly',
                'sub_half',
                'session'
            ]);
            $table->string('transaction_code')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
