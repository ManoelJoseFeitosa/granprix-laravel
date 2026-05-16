<?php

namespace App\Filament\Resources\Escuderias;

use App\Filament\Resources\Escuderias\Pages\CreateEscuderia;
use App\Filament\Resources\Escuderias\Pages\EditEscuderia;
use App\Filament\Resources\Escuderias\Pages\ListEscuderias;
use App\Filament\Resources\Escuderias\Schemas\EscuderiaForm;
use App\Filament\Resources\Escuderias\Tables\EscuderiasTable;
use App\Models\Escuderia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EscuderiaResource extends Resource
{
    protected static ?string $model = Escuderia::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return EscuderiaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EscuderiasTable::configure($table);
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
            'index' => ListEscuderias::route('/'),
            'create' => CreateEscuderia::route('/create'),
            'edit' => EditEscuderia::route('/{record}/edit'),
        ];
    }
}
