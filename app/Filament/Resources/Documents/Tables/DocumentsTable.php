<?php

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
                TextColumn::make('document_number')
                    ->searchable(),
                TextColumn::make('file_number')
                    ->searchable(),
                TextColumn::make('subject')
                    ->searchable(),
                TextColumn::make('document_type_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('priority_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('administration_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sender_type')
                    ->searchable(),
                TextColumn::make('sender_user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('destination_office_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('destination_user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('document_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('response_deadline')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('reference_document_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('registered_by_user_id')
                    ->numeric()
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
