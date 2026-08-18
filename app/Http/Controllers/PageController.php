<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Votacao;
use App\Models\Escuderia;
use App\Models\Criterio;
use App\Models\Voto;
use App\Models\Nota;
use App\Models\Configuracao;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home()
    {
        $homeImage = Configuracao::where('chave', 'home_image')->first()?->valor;
        return view('home', compact('homeImage'));
    }

    public function votacao()
    {
        $votacao_ativa = Votacao::where('esta_ativa', true)->first();
        $criterios = collect();
        if ($votacao_ativa) {
            $criterios = $votacao_ativa->criterios()->orderBy('id')->get();
        }
        $escuderias = Escuderia::all();

        return view('votacao', compact('votacao_ativa', 'criterios', 'escuderias'));
    }

    public function storeVoto(Request $request)
    {
        $votacao_ativa = Votacao::where('esta_ativa', true)->first();
        if (!$votacao_ativa) {
            // Correção pontual: Ajustado o erro de caracteres na string (UTF-8)
            return redirect()->back()->with('error', 'Nenhuma votação ativa.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'escuderia' => 'required|exists:escuderias,id',
        ], [
            'nome.required' => 'Informe o seu nome.',
            'sobrenome.required' => 'Informe o seu sobrenome.',
            'escuderia.required' => 'Selecione uma escuderia.',
            'escuderia.exists' => 'A escuderia selecionada é inválida.',
        ]);

        // Monta o nome completo do jurado (Nome + Sobrenome) normalizando espaços.
        $jurado = preg_replace('/\s+/', ' ', trim($request->nome . ' ' . $request->sobrenome));

        // Validação das notas no servidor: obrigatórias e dentro do intervalo 0..peso_maximo.
        $criterios = $votacao_ativa->criterios;
        $regras_notas = [];
        $mensagens_notas = [];
        foreach ($criterios as $criterio) {
            $campo = 'nota-' . $criterio->id;
            $peso = (int) $criterio->peso_maximo;
            $regras_notas[$campo] = ['required', 'integer', 'min:0', 'max:' . $peso];
            $mensagens_notas[$campo . '.required'] = "A nota do critério \"{$criterio->titulo}\" é obrigatória.";
            $mensagens_notas[$campo . '.integer'] = "A nota do critério \"{$criterio->titulo}\" deve ser um número inteiro.";
            $mensagens_notas[$campo . '.min'] = "A nota do critério \"{$criterio->titulo}\" não pode ser menor que 0.";
            $mensagens_notas[$campo . '.max'] = "A nota do critério \"{$criterio->titulo}\" não pode ser maior que {$peso}.";
        }
        $request->validate($regras_notas, $mensagens_notas);

        // Trava de voto duplicado: o mesmo jurado não pode votar duas vezes
        // na mesma escuderia dentro da mesma votação.
        $ja_votou = Voto::where('votacao_id', $votacao_ativa->id)
            ->where('escuderia_id', $request->escuderia)
            ->whereRaw('LOWER(TRIM(jurado)) = ?', [mb_strtolower($jurado)])
            ->exists();

        if ($ja_votou) {
            return redirect()->route('votacao')
                ->withInput()
                ->with('error', "O jurado \"{$jurado}\" já registrou um voto para esta escuderia nesta votação. Cada jurado pode votar apenas uma vez por escuderia.");
        }

        $voto = Voto::create([
            'votacao_id' => $votacao_ativa->id,
            'jurado' => $jurado,
            'escuderia_id' => $request->escuderia,
        ]);

        foreach ($criterios as $criterio) {
            $valor_nota = $request->input('nota-' . $criterio->id);
            if ($valor_nota !== null) {
                Nota::create([
                    'voto_id' => $voto->id,
                    'criterio_id' => $criterio->id,
                    'valor' => (int) $valor_nota,
                ]);
            }
        }

        $escuderia = Escuderia::find($request->escuderia);

        return redirect()->route('votacao')->with('success', "Voto para a escuderia \"{$escuderia->nome}\" registrado com sucesso!");
    }

    public function resultados()
    {
        $votacao_ativa = Votacao::where('esta_ativa', true)->first();
        $resultados = collect();

        if ($votacao_ativa) {
            $resultados = Escuderia::whereHas('votos', function($q) use ($votacao_ativa) {
                $q->where('votacao_id', $votacao_ativa->id);
            })->withCount(['votos as num_votos' => function($q) use ($votacao_ativa) {
                $q->where('votacao_id', $votacao_ativa->id);
            }])->withSum(['notas as total_pontos' => function($q) use ($votacao_ativa) {
                $q->whereHas('voto', function($q2) use ($votacao_ativa) {
                    $q2->where('votacao_id', $votacao_ativa->id);
                });
            }], 'valor')->get()->map(function($escuderia) {
                $escuderia->nota_final = $escuderia->num_votos > 0 ? ($escuderia->total_pontos / $escuderia->num_votos) : 0;
                return $escuderia;
            })->sortByDesc('nota_final')->values();
        }

        return view('resultados', compact('votacao_ativa', 'resultados'));
    }

    public function historico(Request $request)
    {
        $votacoes_todas = Votacao::orderBy('created_at', 'desc')->get();
        $votacao_id = $request->get('votacao_id');
        
        if ($votacao_id) {
            $votacao_selecionada = Votacao::find($votacao_id);
        } else {
            $votacao_selecionada = $votacoes_todas->where('esta_ativa', true)->first();
        }

        $criterios = collect();
        $votos = collect();

        if ($votacao_selecionada) {
            $criterios = $votacao_selecionada->criterios()->orderBy('id')->get();
            $votos = Voto::where('votacao_id', $votacao_selecionada->id)
                ->with(['escuderia', 'notas.criterio'])
                ->orderBy('jurado')
                ->get();
        }

        return view('historico', compact('criterios', 'votos', 'votacoes_todas', 'votacao_selecionada'));
    }

    public function resultadoEspecifico($votacao_id)
    {
        $votacao = Votacao::findOrFail($votacao_id);
        
        $resultados = Escuderia::whereHas('votos', function($q) use ($votacao) {
            $q->where('votacao_id', $votacao->id);
        })->withCount(['votos as num_votos' => function($q) use ($votacao) {
            $q->where('votacao_id', $votacao->id);
        }])->withSum(['notas as total_pontos' => function($q) use ($votacao) {
            $q->whereHas('voto', function($q2) use ($votacao) {
                $q2->where('votacao_id', $votacao->id);
            });
        }], 'valor')->get()->map(function($escuderia) {
            $escuderia->nota_final = $escuderia->num_votos > 0 ? ($escuderia->total_pontos / $escuderia->num_votos) : 0;
            return $escuderia;
        })->sortByDesc('nota_final')->values();

        return view('resultado_especifico', compact('votacao', 'resultados'));
    }
}
