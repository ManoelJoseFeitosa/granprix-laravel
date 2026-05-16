<?php

namespace App\Filament\Resources\Escuderias\Pages;

use App\Filament\Resources\Escuderias\EscuderiaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEscuderia extends EditRecord
{
    protected static string $resource = EscuderiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
