<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nguoi_dung', function (Blueprint $table) {
            $table->string('nguoi_dung_id', 20)->primary();
            $table->string('ho_ten', 100);
            $table->string('email', 100)->unique();
            $table->string('so_dien_thoai', 15)->unique();
            $table->string('mat_khau', 255);
            $table->enum('vai_tro', ['admin', 'khach_hang'])->default('khach_hang');
            $table->timestamp('ngay_tao')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nguoi_dung');
    }
};
