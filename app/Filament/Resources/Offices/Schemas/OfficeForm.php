<?php

namespace App\Filament\Resources\Offices\Schemas;

use App\Models\Office;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class OfficeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Codigo'),
                TextInput::make('name')
                    ->label('Nombre'),
                TextInput::make('acronym')
                    ->label('siglas'),
                Select::make('parent_office_id')
                    ->options(Office::where('status', true)->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->native(false),
                TextInput::make('level')
                    ->label('Nivel Gerarquico'),
                TextInput::make('manager')
                    ->label('Responsable'),
                ToggleButtons::make('status')
                    ->required()
                    ->boolean()
                    ->grouped()
                    ->default(true),
            ]);
    }
}
