<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('the_loai', function (Blueprint $table) {
            $table->string('the_loai_id', 20)->primary();
            $table->string('ten_the_loai', 100)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('the_loai');
    }
};
