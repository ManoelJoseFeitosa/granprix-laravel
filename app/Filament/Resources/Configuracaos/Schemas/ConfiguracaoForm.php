<?php

namespace App\Filament\Resources\Configuracaos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ConfiguracaoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Hidden::make('chave')->required()->disabled(),
                \Filament\Forms\Components\FileUpload::make('valor')->image()->directory('home')->label('Imagem da Home')
            ]);
    }
}
