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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('total_amount', 12, 2)->comment('үндсэн дүн');
            $table->decimal('discount_percentage', 5, 2)->comment('хямдрал');
            $table->decimal('due_amount', 12, 2)->comment('төлөх дүн');
            $table->enum('status',['remaining_pays', 'completed'])->default('remaining_pays');
            $table->timestamps();
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
