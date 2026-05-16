<?php

namespace App\Filament\Resources\Criterios\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CriterioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->required(),
                Textarea::make('pergunta')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('peso_maximo')
                    ->required()
                    ->numeric(),
            ]);
    }
}
