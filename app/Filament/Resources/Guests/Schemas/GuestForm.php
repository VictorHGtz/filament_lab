<?php

namespace App\Filament\Resources\Guests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GuestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('guest_code'),
                TextInput::make('guest_name')
                    ->required(),
                TextInput::make('max_guests')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('confirmed_guests')
                    ->numeric(),
                DateTimePicker::make('confirmed_at'),
                Textarea::make('message')->disabled()->columnSpanFull(),
            ]);
    }
}
