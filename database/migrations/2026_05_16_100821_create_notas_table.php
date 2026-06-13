<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            // Correção: Apontando a chave estrangeira voto_id para a tabela correta ('votos')
            $table->foreignId('voto_id')->constrained('votos')->cascadeOnDelete();
            $table->foreignId('criterio_id')->constrained('criterios')->cascadeOnDelete();
            $table->unsignedInteger('valor');
            $table->timestamps();
        });
    }
    
    public function down(): void {
        Schema::dropIfExists('notas');
    }
};
