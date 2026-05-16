<?php

namespace App\Filament\Resources\Votacaos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VotacaoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                Toggle::make('esta_ativa')->default(true),
                \Filament\Forms\Components\Select::make('criterios')
                    ->multiple()
                    ->relationship('criterios', 'titulo')
                    ->preload()
                    ->required(),
            ]);
    }
}
