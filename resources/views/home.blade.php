@extends('layouts.app')

@section('content')
<style>
    .home-hero {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
    }

    .home-image-container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto 3rem auto;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        position: relative;
    }

    .home-image-container::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.8) 0%, transparent 40%);
        pointer-events: none;
    }

    .home-image {
        width: 100%;
        max-height: 450px;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    .home-image-container:hover .home-image {
        transform: scale(1.02);
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #fff 0%, var(--accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.1;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-muted);
        max-width: 600px;
        margin: 0 auto 2rem auto;
    }

    .cta-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .placeholder-image {
        width: 100%;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 1.2rem;
        border: 2px dashed rgba(255, 255, 255, 0.1);
        border-radius: 20px;
    }
</style>

<div class="home-hero">
    @if($homeImage)
        <div class="home-image-container">
            {{-- Correção: Força o HTTPS via secure_asset e garante a extração do valor correto da imagem --}}
            <img src="{{ secure_asset('storage/' . (is_object($homeImage) ? $homeImage->valor : $homeImage)) }}" alt="Granprix Banner" class="home-image">
        </div>
    @else
        <div class="placeholder-image">
            <p>Imagem da Home não configurada.<br><span style="font-size:0.9rem">Configure no painel de administração.</span></p>
        </div>
    @endif

    <h1 class="hero-title">Granprix Senai</h1>
    <p class="hero-subtitle">Sistema oficial de avaliação e votação para os projetos das escuderias do desafio Granprix.</p>
    
    <div class="cta-buttons">
        <a href="{{ route('votacao') }}" class="btn">Votar Agora</a>
        <a href="{{ route('resultados') }}" class="btn btn-outline">Ver Resultados</a>
    </div>
</div>
@endsection
