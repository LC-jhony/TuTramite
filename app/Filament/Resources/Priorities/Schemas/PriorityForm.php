<?php

namespace App\Filament\Resources\Priorities\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PriorityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('level')
                    ->required()
                    ->numeric(),
                ColorPicker::make('color_hex')
                    ->required(),
                TextInput::make('day_of_attention')
                    ->required()
                    ->numeric(),
            ]);
    }
}
