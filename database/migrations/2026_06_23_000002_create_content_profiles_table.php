<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('niche');
            $table->string('target_audience')->nullable();
            $table->string('tone');
            $table->string('platform');
            $table->enum('frequency', ['daily', 'weekly']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_profiles');
    }
};
