<?php

namespace App\Filament\Resources\Ciudads\RelationManagers;

use App\Exports\ClientesExport;
use App\Filament\Resources\Clientes\ClienteResource;
use App\Filament\Resources\Clientes\Schemas\ClienteForm;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Maatwebsite\Excel\Facades\Excel;

class ClientesRelationManager extends RelationManager
{
    protected static string $relationship = 'clientes';

    // protected static ?string $relatedResource = ClienteResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nombre'),
            TextInput::make('email')
                ->required()
                ->label('Correo electrónico'),
            TextInput::make('telefono')
                ->required()
                ->label('Teléfono'),
            Toggle::make('activo'),
        ]);

    }

    public function table(Table $table): Table
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
                IconColumn::make('activo')
                    ->label('Estatus')
                    ->boolean(),
            ])
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
            ->headerActions([
                CreateAction::make(),
                Action::make('exportar')
                    ->label('Exportar clientes')
                    ->color('gray')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function () {
                        $ciudad = $this->getOwnerRecord();
                        return Excel::download(
                            new ClientesExport($ciudad),
                            'Clientes '.$ciudad->nombre.'.xlsx'
                        );
                    })
            ]);
    }
}
