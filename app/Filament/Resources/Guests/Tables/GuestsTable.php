<?php

namespace App\Filament\Resources\Guests\Tables;

use App\Imports\GuestImport;
use App\Models\Guest;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Js;
use Maatwebsite\Excel\Facades\Excel;

class GuestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('guest_code')
                    ->searchable(),
                TextColumn::make('guest_name')
                    ->searchable(),
                TextColumn::make('max_guests')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('confirmed_guests')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('confirmed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('copyInvitation')
                    ->label('Link')
                    ->icon('heroicon-o-clipboard-document')
                    ->color('gray')
                    ->extraAttributes(function (Guest $record) {
                        $url = url('/?code=' . $record->guest_code);
                        return [
                            'x-on:click.stop.prevent' => "
                                navigator.clipboard.writeText(" . Js::from($url) . ")
                                    .then(() => {
                                        new FilamentNotification()
                                            .title('Liga copiada')
                                            .success()
                                            .send()
                                    })
                            ",
                        ];
                    })
            ])
            ->toolbarActions([
                Action::make('import')
                    ->label('Import guests')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->schema([
                        FileUpload::make('file')
                            ->label('Excel file')
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->required()
                            ->disk('local')
                            ->directory('imports'),
                    ])
                    ->action(function (array $data) {
                        $path = Storage::disk('local')->path($data['file']);

                        Excel::import(
                            new GuestImport,
                            $path
                        );

                        Storage::disk('local')->delete($data['file']);

                        Notification::make()
                            ->title('Guests imported successfully')
                            ->success()
                            ->send();
                    }),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
