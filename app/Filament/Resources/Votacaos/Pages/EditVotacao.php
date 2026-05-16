<?php

namespace App\Filament\Resources\Votacaos\Pages;

use App\Filament\Resources\Votacaos\VotacaoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVotacao extends EditRecord
{
    protected static string $resource = VotacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
