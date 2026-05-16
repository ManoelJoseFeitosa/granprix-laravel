<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Criterio;
use App\Models\Configuracao;
use App\Models\Votacao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Manoel Feitosa',
                'password' => Hash::make('Mf@871277'),
            ]
        );

        $criterios = [
            ['titulo' => 'Aderencia', 'pergunta' => 'Qual a aderencia da solucao?', 'peso_maximo' => 10],
            ['titulo' => 'Criatividade', 'pergunta' => 'Qual a criatividade da solucao?', 'peso_maximo' => 10],
            ['titulo' => 'Inovacao', 'pergunta' => 'Qual o grau de inovacao?', 'peso_maximo' => 15],
            ['titulo' => 'Atratividade', 'pergunta' => 'Qual a atratividade da solucao?', 'peso_maximo' => 20],
            ['titulo' => 'Canvas', 'pergunta' => 'Avalie o modelo de negocios (Canvas).', 'peso_maximo' => 10],
            ['titulo' => 'Prototipo', 'pergunta' => 'Avalie a qualidade do prototipo.', 'peso_maximo' => 10],
            ['titulo' => 'Pitch', 'pergunta' => 'Como foi a apresentacao (Pitch)?', 'peso_maximo' => 25],
        ];

        $ids = [];
        foreach ($criterios as $c) {
            $cri = Criterio::updateOrCreate(['titulo' => $c['titulo']], $c);
            $ids[] = $cri->id;
        }

        $votacao = Votacao::updateOrCreate(
            ['nome' => 'Primeira Votacao'],
            ['esta_ativa' => true]
        );
        $votacao->criterios()->sync($ids);

        Configuracao::updateOrCreate(
            ['chave' => 'home_image'],
            ['valor' => '']
        );
    }
}
