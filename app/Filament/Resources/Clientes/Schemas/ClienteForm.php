<?php

namespace App\Filament\Resources\Clientes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('telefono')
                    ->tel()
                    ->required(),
                Toggle::make('activo')
                    ->required(),
                Select::make('ciudad_id')
                    ->relationship('ciudad', 'nombre')
                    ->searchable()
                    ->preload()
                    ->label('Ciudad'),
            ]);
    }
}
