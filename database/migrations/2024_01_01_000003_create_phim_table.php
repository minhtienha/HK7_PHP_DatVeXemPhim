<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phim', function (Blueprint $table) {
            $table->string('phim_id', 20)->primary();
            $table->string('ten_phim', 200);
            $table->text('mo_ta')->nullable();
            $table->string('dao_dien', 100)->nullable();
            $table->string('dien_vien', 255)->nullable();
            $table->integer('thoi_luong')->nullable(); // in minutes
            $table->date('ngay_cong_chieu')->nullable();
            $table->enum('trang_thai', ['dang_chieu', 'sap_chieu', 'ngung_chieu'])->default('dang_chieu');
            $table->string('hinh_anh', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phim');
    }
};
