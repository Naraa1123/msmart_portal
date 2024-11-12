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
        Schema::table('subjects', function (Blueprint $table) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->dropColumn('department');
            });

            Schema::table('subjects', function (Blueprint $table) {
                $table->enum('department', ['Программ хангамж', 'График дизайн', 'Интерьер дизайн', 'Хүүхдийн анги', 'Ерөнхий судлах хичээл'])->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->dropColumn('department');
            });

            Schema::table('subjects', function (Blueprint $table) {
                $table->enum('department', ['Программ хангамж', 'График дизайн', 'Интерьер дизайн', 'Хүүхдийн анги'])->nullable();
            });
        });
    }
};
