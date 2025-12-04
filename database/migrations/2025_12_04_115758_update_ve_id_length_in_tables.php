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
        // Tăng độ dài ve_id trong bảng ve
        Schema::table('ve', function (Blueprint $table) {
            $table->string('ve_id', 50)->change();
        });

        // Tăng độ dài ve_id trong bảng ve_tam_thoi
        Schema::table('ve_tam_thoi', function (Blueprint $table) {
            $table->string('ve_id', 50)->change();
        });

        // Tăng độ dài ve_id trong bảng chi_tiet_ve
        Schema::table('chi_tiet_ve', function (Blueprint $table) {
            $table->string('ve_id', 50)->change();
        });

        // Tăng độ dài ve_id trong bảng chi_tiet_ve_tam_thoi
        Schema::table('chi_tiet_ve_tam_thoi', function (Blueprint $table) {
            $table->string('ve_id', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback về độ dài cũ
        Schema::table('ve', function (Blueprint $table) {
            $table->string('ve_id', 20)->change();
        });

        Schema::table('ve_tam_thoi', function (Blueprint $table) {
            $table->string('ve_id', 20)->change();
        });

        Schema::table('chi_tiet_ve', function (Blueprint $table) {
            $table->string('ve_id', 20)->change();
        });

        Schema::table('chi_tiet_ve_tam_thoi', function (Blueprint $table) {
            $table->string('ve_id', 20)->change();
        });
    }
};
