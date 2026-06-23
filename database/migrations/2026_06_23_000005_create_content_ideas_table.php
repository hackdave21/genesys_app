<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_ideas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->text('prompt_used')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->enum('status', ['generated', 'sent', 'failed'])->default('generated');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_ideas');
    }
};
