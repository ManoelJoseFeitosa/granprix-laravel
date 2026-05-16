<?php

namespace App\Filament\Resources\Votacaos;

use App\Filament\Resources\Votacaos\Pages\CreateVotacao;
use App\Filament\Resources\Votacaos\Pages\EditVotacao;
use App\Filament\Resources\Votacaos\Pages\ListVotacaos;
use App\Filament\Resources\Votacaos\Schemas\VotacaoForm;
use App\Filament\Resources\Votacaos\Tables\VotacaosTable;
use App\Models\Votacao;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VotacaoResource extends Resource
{
    protected static ?string $model = Votacao::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nome';

    public static function form(Schema $schema): Schema
    {
        return VotacaoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VotacaosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVotacaos::route('/'),
            'create' => CreateVotacao::route('/create'),
            'edit' => EditVotacao::route('/{record}/edit'),
        ];
    }
}
