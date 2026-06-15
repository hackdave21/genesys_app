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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', ['Publicité', 'Événement', 'Reels', 'Corporate']);
            $table->text('description')->nullable();
            $table->string('client')->nullable();
            $table->string('video_url');
            $table->string('embed_url');
            $table->string('thumbnail_url')->nullable();
            $table->enum('status', ['visible', 'archive'])->default('visible');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
