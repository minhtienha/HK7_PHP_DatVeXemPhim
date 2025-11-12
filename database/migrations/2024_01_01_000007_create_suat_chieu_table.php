<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suat_chieu', function (Blueprint $table) {
            $table->string('suat_chieu_id', 20)->primary();
            $table->string('phim_id', 20);
            $table->string('phong_id', 20);
            $table->decimal('gia_ve', 10, 2);
            $table->date('ngay_chieu');
            $table->time('gio_bat_dau');
            $table->time('gio_ket_thuc');
            $table->enum('trang_thai', ['con_cho', 'het_cho', 'huy'])->default('con_cho');
            
            $table->foreign('phim_id')->references('phim_id')->on('phim')->onDelete('cascade');
            $table->foreign('phong_id')->references('phong_id')->on('phong_chieu')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suat_chieu');
    }
};
