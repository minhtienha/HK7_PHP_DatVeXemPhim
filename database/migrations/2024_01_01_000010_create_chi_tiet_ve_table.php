<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_tiet_ve', function (Blueprint $table) {
            $table->string('ve_id', 20);
            $table->string('ghe_id', 20);
            
            $table->primary(['ve_id', 'ghe_id']);
            
            $table->foreign('ve_id')->references('ve_id')->on('ve')->onDelete('cascade');
            $table->foreign('ghe_id')->references('ghe_id')->on('ghe_ngoi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_ve');
    }
};
