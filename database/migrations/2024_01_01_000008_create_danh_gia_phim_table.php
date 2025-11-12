<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danh_gia_phim', function (Blueprint $table) {
            $table->string('danh_gia_id', 20)->primary();
            $table->string('nguoi_dung_id', 20);
            $table->string('phim_id', 20);
            $table->integer('diem'); // 1-5 or 1-10
            $table->text('binh_luan')->nullable();
            
            $table->foreign('nguoi_dung_id')->references('nguoi_dung_id')->on('nguoi_dung')->onDelete('cascade');
            $table->foreign('phim_id')->references('phim_id')->on('phim')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_gia_phim');
    }
};
