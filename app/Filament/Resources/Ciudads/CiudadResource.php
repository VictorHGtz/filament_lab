<?php

namespace App\Filament\Resources\Ciudads;

use App\Filament\Resources\Ciudads\Pages\CreateCiudad;
use App\Filament\Resources\Ciudads\Pages\EditCiudad;
use App\Filament\Resources\Ciudads\Pages\ListCiudads;
use App\Filament\Resources\Ciudads\RelationManagers\ClientesRelationManager;
use App\Filament\Resources\Ciudads\Schemas\CiudadForm;
use App\Filament\Resources\Ciudads\Tables\CiudadsTable;
use App\Models\Ciudad;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CiudadResource extends Resource
{
    protected static ?string $model = Ciudad::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Schema $schema): Schema
    {
        return CiudadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CiudadsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
            ClientesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCiudads::route('/'),
            'create' => CreateCiudad::route('/create'),
            'edit' => EditCiudad::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
