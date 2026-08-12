<?php

namespace App\Filament\Resources\Guests\Pages;

use App\Filament\Resources\Guests\GuestResource;
use App\Filament\Resources\Guests\Widgets\GuestOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGuests extends ListRecords
{
    protected static string $resource = GuestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            GuestOverview::class,
        ];
    }
}
