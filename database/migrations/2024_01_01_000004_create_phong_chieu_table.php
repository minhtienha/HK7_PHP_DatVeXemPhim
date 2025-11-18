<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phong_chieu', function (Blueprint $table) {
            $table->string('phong_id', 20)->primary();
            $table->string('ten_phong', 50)->unique();
            $table->integer('suc_chua');
            $table->timestamp('ngay_tao')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phong_chieu');
    }
};
