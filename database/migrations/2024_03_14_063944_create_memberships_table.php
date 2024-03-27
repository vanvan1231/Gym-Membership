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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->timestamp('sub_start_date')->nullable();
            $table->timestamp('sub_end_date')->nullable();
            $table->timestamp('mem_start_date')->nullable();
            $table->timestamp('mem_end_date')->nullable();
            $table->enum('mem_status', ['active', 'expired'])->nullable();
            $table->enum('sub_status', ['active', 'cancelled'])->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
