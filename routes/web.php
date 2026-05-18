<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/votar', [PageController::class, 'votacao'])->name('votacao');
Route::post('/votar', [PageController::class, 'storeVoto']);
Route::get('/resultados', [PageController::class, 'resultados'])->name('resultados');
Route::get('/historico', [PageController::class, 'historico'])->name('historico');
Route::get('/historico/{id}', [PageController::class, 'resultadoEspecifico'])->name('resultado_especifico');

// Rota customizada para entrega de arquivos do Storage (Solução para o bloqueio da Hostinger)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath);
})->where('path', '.*');
