<?php

namespace App\Filament\Resources\Votacaos\Pages;

use App\Filament\Resources\Votacaos\VotacaoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVotacaos extends ListRecords
{
    protected static string $resource = VotacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
