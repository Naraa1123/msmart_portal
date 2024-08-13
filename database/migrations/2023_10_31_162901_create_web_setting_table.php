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
        Schema::create('web_setting', function (Blueprint $table) {
            $table->string('id');
            $table->string('web_name');
            $table->string('address');
            $table->string('web_logo');
            $table->string('email');
            $table->bigInteger('phone_number');
            $table->bigInteger('account_number')->nullable();
            $table->string('account_name')->nullable();

            $table->longText('google_map_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_setting');
    }
};
