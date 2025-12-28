<?php

declare(strict_types=1);

namespace App\Filament\Resources\Documents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client')
                    ->label('Cliente')
                    ->getStateUsing(fn ($record) => $record->client ? $record->client->dni.' '.$record->client->ruc : ''),
                TextColumn::make('document_number')
                    ->label('Numero'),
                TextColumn::make('case_number')
                    ->label('Caso'),
                // TextColumn::make('subject'),
                TextColumn::make('origen')
                    ->label('Origén')
                    ->badge(),
                // TextColumn::make('documentType.name'),
                TextColumn::make('officeOrigen.name')
                    ->label('Oficina'),
                // TextColumn::make('gestion.name')
                //     ->badge(),
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->placeholder('N/A'),
                TextColumn::make('folio')
                    ->label('Folio'),
                TextColumn::make('reception_date')
                    ->label('Rescepción'),
                TextColumn::make('response_deadline')
                    ->label('Respuesta'),
                // TextColumn::make('condition'),
                TextColumn::make('status')
                    ->label('Estado'),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
