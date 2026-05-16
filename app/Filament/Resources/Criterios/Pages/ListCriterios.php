<?php

namespace App\Filament\Resources\Criterios\Pages;

use App\Filament\Resources\Criterios\CriterioResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCriterios extends ListRecords
{
    protected static string $resource = CriterioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
