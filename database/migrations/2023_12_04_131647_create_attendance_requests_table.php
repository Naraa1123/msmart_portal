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
        Schema::create('attendance_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('request_type',['өвчтэй','чөлөө']);
            $table->longText('description');
            $table->date('request_start_date')->default(now());
            $table->date('request_end_date');
            $table->string('attachment')->nullable();
            $table->enum('request_decision',['зөвшөөрөгдөөгүй','зөвшөөрөгдсөн','шийдвэр_гараагүй'])->default('шийдвэр_гараагүй');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_requests');
    }
};
