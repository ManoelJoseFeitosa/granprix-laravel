<?php

namespace App\Filament\Resources\Criterios;

use App\Filament\Resources\Criterios\Pages\CreateCriterio;
use App\Filament\Resources\Criterios\Pages\EditCriterio;
use App\Filament\Resources\Criterios\Pages\ListCriterios;
use App\Filament\Resources\Criterios\Schemas\CriterioForm;
use App\Filament\Resources\Criterios\Tables\CriteriosTable;
use App\Models\Criterio;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CriterioResource extends Resource
{
    protected static ?string $model = Criterio::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CriterioForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CriteriosTable::configure($table);
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
            'index' => ListCriterios::route('/'),
            'create' => CreateCriterio::route('/create'),
            'edit' => EditCriterio::route('/{record}/edit'),
        ];
    }
}
