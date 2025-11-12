<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ve', function (Blueprint $table) {
            $table->string('ve_id', 20)->primary();
            $table->string('nguoi_dung_id', 20);
            $table->string('suat_chieu_id', 20);
            $table->timestamp('thoi_gian_dat')->nullable();
            $table->decimal('tong_tien', 10, 2);
            
            $table->foreign('nguoi_dung_id')->references('nguoi_dung_id')->on('nguoi_dung')->onDelete('cascade');
            $table->foreign('suat_chieu_id')->references('suat_chieu_id')->on('suat_chieu')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ve');
    }
};
