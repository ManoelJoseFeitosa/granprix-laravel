<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('votos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('votacao_id')->constrained('votacaos')->cascadeOnDelete();
            $table->string('jurado');
            $table->foreignId('escuderia_id')->constrained('escuderias')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('votos');
    }
};