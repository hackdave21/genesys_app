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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('quote_id')->nullable()->constrained('quotes')->onDelete('set null');
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('progress')->default(0);
            $table->enum('step', ['Scripting', 'Tournage', 'Montage', 'Terminé'])->default('Scripting');
            $table->enum('priority', ['Bas', 'Moyen', 'Urgent'])->default('Moyen');
            $table->json('team')->nullable(); // JSON list of user handles (e.g., ['TA', 'AK'])
            $table->date('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
