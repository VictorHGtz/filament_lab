<?php

namespace App\Filament\Resources\Guests\Widgets;

use App\Models\Guest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GuestOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalGuests = Guest::sum('max_guests');
        $confirmedGuests = Guest::sum('confirmed_guests');

        return [
            Stat::make('Invitados', $totalGuests)
                ->description('Total de invitados')
                ->icon('heroicon-o-users'),

            Stat::make('Confirmados', $confirmedGuests)
                ->description('Personas que han confirmado')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
