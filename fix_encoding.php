<?php

use App\Models\Votacao;
use App\Models\Criterio;

$votacao = Votacao::first();
if ($votacao) {
    $votacao->nome = 'Primeira Votação';
    $votacao->save();
}

$criteriosData = [
    1 => ['titulo' => 'Aderência', 'pergunta' => 'Qual a aderência da solução?'],
    2 => ['titulo' => 'Criatividade', 'pergunta' => 'Qual a criatividade da solução?'],
    3 => ['titulo' => 'Inovação', 'pergunta' => 'Qual o grau de inovação?'],
    4 => ['titulo' => 'Atratividade', 'pergunta' => 'Qual a atratividade da solução?'],
    5 => ['titulo' => 'Canvas', 'pergunta' => 'Avalie o modelo de negócios (Canvas).'],
    6 => ['titulo' => 'Protótipo', 'pergunta' => 'Avalie a qualidade do protótipo.'],
    7 => ['titulo' => 'Pitch', 'pergunta' => 'Como foi a apresentação (Pitch)?'],
];

foreach ($criteriosData as $id => $data) {
    $c = Criterio::find($id);
    if ($c) {
        $c->titulo = $data['titulo'];
        $c->pergunta = $data['pergunta'];
        $c->save();
    }
}