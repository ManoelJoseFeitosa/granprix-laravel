<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('votacaos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->boolean('esta_ativa')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('votacaos');
    }
};