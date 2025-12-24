<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('document_number'),
                TextEntry::make('file_number'),
                TextEntry::make('subject'),
                TextEntry::make('document_type_id')
                    ->numeric(),
                TextEntry::make('priority_id')
                    ->numeric(),
                TextEntry::make('administration_id')
                    ->numeric(),
                TextEntry::make('sender_type'),
                TextEntry::make('sender_user_id')
                    ->numeric(),
                TextEntry::make('destination_office_id')
                    ->numeric(),
                TextEntry::make('destination_user_id')
                    ->numeric(),
                TextEntry::make('content')
                    ->columnSpanFull(),
                TextEntry::make('document_date')
                    ->date(),
                TextEntry::make('response_deadline')
                    ->date(),
                TextEntry::make('status'),
                TextEntry::make('reference_document_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('registered_by_user_id')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
