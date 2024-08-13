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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('firstname');
            $table->string('lastname');
            $table->enum('gender',['male','female','other']);
            $table->string('registration_number');
            $table->enum('status',['graduated','studying','took_leave','dropped_out'])->default('studying');
            $table->integer('phone_number_1');
            $table->integer('phone_number_2')->nullable();
            $table->integer('phone_number_3')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('admission_year')->default(now());
            $table->string('guardian_name')->nullable();
            $table->integer('guardian_phone_number')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
