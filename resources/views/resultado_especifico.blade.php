@extends('layouts.app')

@section('content')
<style>
    .winner-row {
        background: rgba(251, 191, 36, 0.1) !important;
    }

    .winner-row td {
        color: var(--gold);
        font-weight: 600;
    }
</style>

<div style="max-width: 1000px; margin: 0 auto;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <h1 class="page-title" style="margin: 0; font-size: 2rem;">Classificação Final</h1>
        <a href="{{ route('historico', ['votacao_id' => $votacao->id]) }}" class="btn btn-outline" style="padding: 0.5rem 1rem;">Voltar aos Votos</a>
    </div>

    <div class="glass-card">
        <h2 style="text-align: center; margin-bottom: 2rem; color: var(--accent);">{{ $votacao->nome }}</h2>

        @if($resultados->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 80px; text-align: center;">Posição</th>
                            <th>Escuderia</th>
                            <th style="text-align: center;">Votos Computados</th>
                            <th style="text-align: right;">Média Final</th>
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
                Nenhum voto registrado para exibir a classificação desta votação.
            </div>
        @endif
    </div>
</div>
@endsection
