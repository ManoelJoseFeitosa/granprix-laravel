<?php

namespace App\Filament\Resources\Criterios\Pages;

use App\Filament\Resources\Criterios\CriterioResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCriterio extends EditRecord
{
    protected static string $resource = CriterioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
