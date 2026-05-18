@extends('layouts.app')

@section('content')
<style>
    .history-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2rem;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li {
        margin-bottom: 0.5rem;
    }

    .sidebar-menu a {
        display: block;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-menu a:hover {
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-main);
    }

    .sidebar-menu a.active {
        background: rgba(37, 99, 235, 0.15);
        color: var(--accent);
        border-left-color: var(--accent);
        font-weight: 600;
    }

    .badge-status {
        float: right;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 10px;
    }

    .vote-card {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .vote-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .vote-scores {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .score-item {
        background: rgba(255, 255, 255, 0.03);
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .score-item span {
        color: var(--accent);
        font-weight: bold;
        margin-left: 5px;
    }

    @media (max-width: 768px) {
        .history-layout {
            grid-template-columns: 1fr;
        }
        .vote-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .vote-header > div:last-child {
            text-align: left;
        }
        .vote-scores {
            justify-content: space-between;
        }
        .score-item {
            flex: 1 1 45%;
            text-align: center;
            box-sizing: border-box;
        }
    }
</style>

<div class="history-layout">
    <div class="glass-card" style="padding: 1.5rem; align-self: start;">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-muted); font-size: 1rem; text-transform: uppercase;">Votações</h3>
        <ul class="sidebar-menu">
            @foreach($votacoes_todas as $v)
                <li>
                    <a href="{{ route('historico', ['votacao_id' => $v->id]) }}" 
                       class="{{ ($votacao_selecionada && $votacao_selecionada->id == $v->id) ? 'active' : '' }}">
                        {{ $v->nome }}
                        @if($v->esta_ativa)
                            <span class="badge-status badge-active">ATIVA</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="glass-card">
        @if($votacao_selecionada)
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="margin: 0; color: var(--accent);">{{ $votacao_selecionada->nome }}</h2>
                <a href="{{ route('resultado_especifico', $votacao_selecionada->id) }}" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Ver Classificação Final</a>
            </div>

            @if($votos->count() > 0)
                <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Votos Registrados ({{ $votos->count() }})</h3>
                
                @foreach($votos as $voto)
                    <div class="vote-card">
                        <div class="vote-header">
                            <div>
                                <strong style="font-size: 1.1rem; display: block; color: var(--text-main);">{{ $voto->jurado }}</strong>
                                <span style="color: var(--text-muted); font-size: 0.9rem;">Avaliador</span>
                            </div>
                            <div style="text-align: right;">
                                <strong style="font-size: 1.1rem; color: #fbbf24;">{{ $voto->escuderia->nome }}</strong>
                                <div style="color: var(--text-muted); font-size: 0.8rem;">Escuderia Avaliada</div>
                            </div>
                        </div>
                        <div class="vote-scores">
                            @foreach($voto->notas as $nota)
                                <div class="score-item">
                                    {{ $nota->criterio->titulo }}: <span>{{ $nota->valor }}</span>
                                </div>
                            @endforeach
                            <div class="score-item" style="background: rgba(37, 99, 235, 0.1); border: 1px solid rgba(37, 99, 235, 0.3);">
                                Total: <span>{{ $voto->notas->sum('valor') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; color: var(--text-muted); padding: 3rem;">
                    Nenhum voto foi registrado nesta votação.
                </div>
            @endif
        @else
            <div style="text-align: center; color: var(--text-muted); padding: 3rem;">
                Selecione uma votação no menu lateral para visualizar os votos.
            </div>
        @endif
    </div>
</div>
@endsection
