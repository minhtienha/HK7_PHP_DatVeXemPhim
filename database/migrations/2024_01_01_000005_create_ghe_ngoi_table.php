<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ghe_ngoi', function (Blueprint $table) {
            $table->string('ghe_id', 20)->primary();
            $table->string('phong_id', 20);
            $table->string('so_ghe', 10);
            
            $table->foreign('phong_id')->references('phong_id')->on('phong_chieu')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ghe_ngoi');
    }
};
