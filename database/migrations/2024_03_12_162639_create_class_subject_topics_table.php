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
        Schema::create('class_subject_topics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_subject_id')->nullable();
            $table->foreign('class_subject_id')->references('id')->on('class_subjects')->onDelete('cascade');
            $table->string('topic');
            $table->date('date_of_topic');
            $table->string('homework')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_subject_topics');
    }
};
