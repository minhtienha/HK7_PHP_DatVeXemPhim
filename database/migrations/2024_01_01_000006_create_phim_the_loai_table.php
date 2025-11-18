<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phim_the_loai', function (Blueprint $table) {
            $table->string('phim_id', 20);
            $table->string('the_loai_id', 20);

            $table->primary(['phim_id', 'the_loai_id']);

            $table->foreign('phim_id')->references('phim_id')->on('phim')->onDelete('cascade');
            $table->foreign('the_loai_id')->references('the_loai_id')->on('the_loai')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phim_the_loai');
    }
};
