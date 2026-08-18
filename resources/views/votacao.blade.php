@extends('layouts.app')

@section('content')
<style>
    .form-wrapper {
        max-width: 800px;
        margin: 0 auto;
    }

    .criteria-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .criterion-card {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .criterion-card:hover {
        border-color: var(--accent);
        background: rgba(0, 0, 0, 0.3);
    }

    .criterion-title {
        font-weight: 800;
        color: var(--accent);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .criterion-question {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
        height: 40px;
    }

    .criterion-input {
        text-align: center;
        font-size: 1.5rem !important;
        font-weight: 800;
        padding: 1rem !important;
    }

    .score-hint {
        text-align: center;
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.5rem;
        display: block;
    }

    .submit-area {
        text-align: center;
        margin-top: 3rem;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state h3 {
        color: var(--text-muted);
        font-weight: 400;
    }

    @media (max-width: 768px) {
        .criteria-grid {
            grid-template-columns: 1fr;
        }
        .submit-area .btn {
            width: 100%;
            max-width: 100% !important;
        }
    }
</style>

<div class="form-wrapper">
    <h1 class="page-title">Área de Votação</h1>

    @if($votacao_ativa)
        <div class="glass-card">
            <h2 style="text-align: center; margin-bottom: 2rem;">Votação Ativa: <span style="color:var(--accent)">{{ $votacao_ativa->nome }}</span></h2>

            <form method="POST" action="{{ route('votacao') }}">
                @csrf

                <div class="form-group">
                    <label for="nome">Nome (Avaliador)</label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required placeholder="Digite seu nome">
                </div>

                <div class="form-group">
                    <label for="sobrenome">Sobrenome (Avaliador)</label>
                    <input type="text" id="sobrenome" name="sobrenome" value="{{ old('sobrenome') }}" required placeholder="Digite seu sobrenome">
                </div>

                <div class="form-group">
                    <label for="escuderia">Equipe Avaliada</label>
                    <select id="escuderia" name="escuderia" required>
                        <option value="">Selecione uma Escuderia...</option>
                        @foreach($escuderias as $escuderia)
                            <option value="{{ $escuderia->id }}" {{ (string) old('escuderia') === (string) $escuderia->id ? 'selected' : '' }}>{{ $escuderia->nome }}</option>
                        @endforeach
                    </select>
                </div>

                @if($criterios->count() > 0)
                    <div class="criteria-grid">
                        @foreach($criterios as $criterio)
                            <div class="criterion-card">
                                <div class="criterion-title">{{ $criterio->titulo }}</div>
                                <div class="criterion-question">{{ $criterio->pergunta }}</div>
                                
                                <input type="number"
                                       class="criterion-input"
                                       id="nota-{{ $criterio->id }}"
                                       name="nota-{{ $criterio->id }}"
                                       value="{{ old('nota-' . $criterio->id) }}"
                                       min="0"
                                       max="{{ $criterio->peso_maximo }}"
                                       required
                                       placeholder="0">
                                <span class="score-hint">Nota de 0 a {{ $criterio->peso_maximo }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-error" style="margin-top: 2rem;">
                        Esta votação não possui critérios cadastrados.
                    </div>
                @endif

                <div class="submit-area">
                    <button type="submit" class="btn" style="width: 100%; max-width: 300px; padding: 1rem; font-size: 1.1rem;">
                        Registrar Voto
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="glass-card empty-state">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--text-muted); margin-bottom: 1rem;"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg>
            <h3>Não há nenhuma votação ativa no momento.</h3>
            <p style="color: var(--text-muted)">Aguarde a organização iniciar uma nova votação.</p>
        </div>
    @endif
</div>
@endsection
