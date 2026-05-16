<?php

namespace App\Filament\Resources\Escuderias\Pages;

use App\Filament\Resources\Escuderias\EscuderiaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEscuderias extends ListRecords
{
    protected static string $resource = EscuderiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
