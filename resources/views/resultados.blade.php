@extends('layouts.app')

@section('content')
<style>
    .results-wrapper {
        max-width: 1000px;
        margin: 0 auto;
    }

    .podium {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 4rem;
        height: 250px;
    }

    .podium-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 180px;
        background: var(--surface);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        position: relative;
        backdrop-filter: blur(8px);
    }

    .podium-item.first {
        height: 200px;
        background: linear-gradient(to top, rgba(251, 191, 36, 0.2), var(--surface));
        border-color: rgba(251, 191, 36, 0.3);
        z-index: 3;
    }

    .podium-item.second {
        height: 160px;
        background: linear-gradient(to top, rgba(148, 163, 184, 0.2), var(--surface));
        border-color: rgba(148, 163, 184, 0.3);
        z-index: 2;
    }

    .podium-item.third {
        height: 130px;
        background: linear-gradient(to top, rgba(180, 83, 9, 0.2), var(--surface));
        border-color: rgba(180, 83, 9, 0.3);
        z-index: 1;
    }

    .podium-rank {
        position: absolute;
        top: -25px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.5rem;
        color: white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.5);
    }

    .first .podium-rank { background: #fbbf24; }
    .second .podium-rank { background: #94a3b8; }
    .third .podium-rank { background: #b45309; }

    .podium-team {
        margin-top: 40px;
        font-weight: 800;
        text-align: center;
        padding: 0 10px;
    }

    .podium-score {
        margin-top: 10px;
        font-size: 1.25rem;
        color: var(--accent);
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .podium {
            gap: 10px;
            margin-bottom: 3rem;
            height: 200px;
        }
        .podium-item {
            width: 30%;
            min-width: 85px;
        }
        .podium-team {
            font-size: 0.75rem;
            margin-top: 35px;
            word-wrap: break-word;
            padding: 0 5px;
            text-align: center;
        }
        .podium-score {
            font-size: 1rem;
            margin-top: 5px;
        }
        .podium-item.first { height: 170px; }
        .podium-item.second { height: 130px; }
        .podium-item.third { height: 100px; }
        .podium-rank {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            top: -20px;
        }
        table {
            font-size: 0.9rem;
        }
        th, td {
            padding: 0.75rem 0.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .podium-team {
            font-size: 0.7rem;
        }
        .podium-score {
            font-size: 0.9rem;
        }
    }
</style>

<div class="results-wrapper">
    <h1 class="page-title">Resultados Parciais</h1>

    @if($votacao_ativa)
        <p style="text-align: center; margin-bottom: 3rem; color: var(--text-muted);">
            Votação Atual: <strong>{{ $votacao_ativa->nome }}</strong>
        </p>

        @if($resultados->count() >= 3)
            <div class="podium">
                <!-- Segundo Lugar (index 1) -->
                @if(isset($resultados[1]))
                <div class="podium-item second">
                    <div class="podium-rank">2</div>
                    <div class="podium-team">{{ $resultados[1]->nome }}</div>
                    <div class="podium-score">{{ number_format($resultados[1]->nota_final, 2) }}</div>
                </div>
                @endif
                
                <!-- Primeiro Lugar (index 0) -->
                <div class="podium-item first">
                    <div class="podium-rank">1</div>
                    <div class="podium-team">{{ $resultados[0]->nome }}</div>
                    <div class="podium-score">{{ number_format($resultados[0]->nota_final, 2) }}</div>
                </div>

                <!-- Terceiro Lugar (index 2) -->
                @if(isset($resultados[2]))
                <div class="podium-item third">
                    <div class="podium-rank">3</div>
                    <div class="podium-team">{{ $resultados[2]->nome }}</div>
                    <div class="podium-score">{{ number_format($resultados[2]->nota_final, 2) }}</div>
                </div>
                @endif
            </div>
        @endif

        <div class="glass-card">
            @if($resultados->count() > 0)
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 80px; text-align: center;">Posição</th>
                                <th>Escuderia</th>
                                <th style="text-align: center;">Votos Registrados</th>
                                <th style="text-align: right;">Nota Média Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resultados as $index => $resultado)
                                <tr class="{{ $index === 0 ? 'winner-row' : '' }}">
                                    <td style="text-align: center; font-weight: bold;">
                                        @if($index === 0) 🏆 @else {{ $index + 1 }}º @endif
                                    </td>
                                    <td>{{ $resultado->nome }}</td>
                                    <td style="text-align: center;">{{ $resultado->num_votos }}</td>
                                    <td style="text-align: right; font-weight: bold;">
                                        {{ number_format($resultado->nota_final, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; color: var(--text-muted); padding: 2rem;">
                    Nenhum voto registrado para as escuderias nesta votação ainda.
                </div>
            @endif
        </div>
    @else
        <div class="glass-card" style="text-align: center; padding: 4rem;">
            <h3>Não há votação ativa.</h3>
            <p style="color: var(--text-muted); margin-top: 1rem;">Consulte o Histórico para ver resultados anteriores.</p>
            <a href="{{ route('historico') }}" class="btn" style="margin-top: 2rem;">Acessar Histórico</a>
        </div>
    @endif
</div>
@endsection
