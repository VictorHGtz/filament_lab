<?php

namespace App\Filament\Resources\Ciudads\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CiudadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('estado'),
                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
