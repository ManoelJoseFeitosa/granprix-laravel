<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('criterio_votacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criterio_id')->constrained('criterios')->cascadeOnDelete();
            $table->foreignId('votacao_id')->constrained('votacaos')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('criterio_votacao');
    }
};