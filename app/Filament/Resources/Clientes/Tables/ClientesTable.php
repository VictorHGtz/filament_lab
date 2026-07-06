<?php

namespace App\Filament\Resources\Clientes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;

class ClientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable(),
                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable(),
                TextColumn::make('ciudad.nombre')
                    ->label('Ciudad'),
                IconColumn::make('activo')
                    ->label('Estatus')
                    ->boolean(),
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
                TrashedFilter::make(),
            ])
            ->recordActionsColumnLabel('Opciones')
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->tooltip('Ver'),
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Editar'),
                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Eliminar'),
                RestoreAction::make()
                    ->iconButton()
                    ->tooltip('Restaurar'),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
