<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('class_videos', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('path_video');
            $table->string('thumbnail_video');
            $table->unsignedBigInteger('category_classes_id');
            $table->foreign('category_classes_id')->references('id')->on('category_classes')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_videos');
    }
};
