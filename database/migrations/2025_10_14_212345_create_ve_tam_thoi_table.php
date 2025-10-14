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
        Schema::create('ve_tam_thoi', function (Blueprint $table) {
            $table->string('ve_id')->primary();
            $table->string('nguoi_dung_id');
            $table->string('suat_chieu_id');
            $table->timestamp('thoi_gian_dat');
            $table->integer('tong_tien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ve_tam_thoi');
    }
};
