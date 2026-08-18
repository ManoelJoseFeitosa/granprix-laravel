<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/votar', [PageController::class, 'votacao'])->name('votacao');
Route::post('/votar', [PageController::class, 'storeVoto']);

// Resultados e histórico ficam restritos ao admin autenticado (jurados não podem
// ver o parcial). Visitantes são redirecionados para o login do painel.
Route::middleware('auth')->group(function () {
    Route::get('/resultados', [PageController::class, 'resultados'])->name('resultados');
    Route::get('/historico', [PageController::class, 'historico'])->name('historico');
    Route::get('/historico/{id}', [PageController::class, 'resultadoEspecifico'])->name('resultado_especifico');
});

// Rota customizada para burlar o bloqueio de diretórios nativos do LiteSpeed na Hostinger
Route::get('/file-media/{path}', function ($path) {
    // Limpa possíveis barras duplicadas na string
    $path = ltrim($path, '/');
    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath);
})->where('path', '.*');
