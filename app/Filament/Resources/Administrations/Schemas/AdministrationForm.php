<?php

namespace App\Filament\Resources\Administrations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class AdministrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('start_period')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(
                        function ($state, $get, $set) {
                            $start = (int) $state;
                            if ($start > 0) {
                                $end = $start + 3;
                                $set('end_period', $end);
                                $set('name', "Gestión Municipal {$start} - {$end}");
                            }
                        }
                    ),
                TextInput::make('end_period')
                    ->required(),
                TextInput::make('mayor')
                    ->required(),
                ToggleButtons::make('status')
                    ->required()
                    ->boolean()
                    ->grouped()
                    ->default(true)
                    ->reactive()
                    ->afterStateUpdated(
                        function ($state, $set) {
                            $set('status', $state);
                            if ($state) {
                                session()->now('filament.notifications', [
                                    'title' => 'Estado cambiado',
                                    'message' => 'La gestión fue marcada como activa.',
                                    'status' => 'success',
                                ]);
                            }
                        }
                    ),
            ]);
    }
}
