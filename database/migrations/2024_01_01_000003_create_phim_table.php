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
            $table->string('ten_phim', 255);
            $table->text('mo_ta')->nullable();
            $table->string('dao_dien', 100)->nullable();
            $table->text('dien_vien')->nullable();
            $table->integer('thoi_luong')->nullable();
            $table->date('ngay_cong_chieu')->nullable();
            $table->enum('trang_thai', ['sap_chieu', 'dang_chieu', 'ngung_chieu'])->default('sap_chieu');
            $table->string('hinh_anh', 255)->nullable();
            $table->timestamp('ngay_tao')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phim');
    }
};
