<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Administration;
use App\Models\DocumentType;
use App\Models\Priority;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('document_number')
                    ->label('Número de Documento')
                    ->required(),
                TextInput::make('file_number')
                    ->label('Número de Expediente')
                    ->required(),
                Textarea::make('subject')
                    ->label('Asunto')
                    ->required(),
                Select::make('document_type_id')
                    ->label('Tipo de Documento')
                    ->options(DocumentType::where('status', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->native(false),
                Select::make('priority_id')
                    ->label('Prioridad')
                    ->options(function () {
                        $priorities = DB::table('priorities')->select('id', 'name', 'color_hex')->get();
                        $opts = [];
                        foreach ($priorities as $priority) {
                            //  $opts[$priority->id] = $priority->name . ' (' . $priority->color_hex . ')';
                            $opts[$priority->id] = "{$priority->name} <span style='display:inline-block; width: 20px; height: 20px; background-color:{$priority->color_hex};  border-radius: 20%; vertical-align:middle; margin-left: 5px;'></span>";
                        }
                        return $opts;
                    })
                    ->allowHtml()
                    ->native(false),
                Select::make('administration_id')
                    ->label('gestión')
                    ->options(Administration::where('status', true)->pluck('name', 'id'))
                    ->default(fn() => Administration::where(
                        'status',
                        true
                    )
                        ->first()
                        ?->id)
                    ->searchable()
                    ->required()
                    ->dehydrated()
                    ->disabled()
                    ->native(false),
                TextInput::make('sender_type')
                    ->required(),
                TextInput::make('sender_user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('destination_office_id')
                    ->required()
                    ->numeric(),
                TextInput::make('destination_user_id')
                    ->required()
                    ->numeric(),
                RichEditor::make('content')
                    ->label('Contenido/Observaciones')
                    ->required()
                    ->columnSpanFull(),
                DatePicker::make('document_date')
                    ->label('Fecha del Documento')
                    ->required()
                    ->default(now())
                    ->disabled()
                    ->dehydrated(),
                DatePicker::make('response_deadline')
                    ->label('Fecha Límite de Respuesta')
                    ->required()
                    ->minDate(now())
                    ->native(false),
                TextInput::make('status')
                    ->required(),
                TextInput::make('reference_document_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('registered_by_user_id')
                    ->required()
                    ->numeric(),
                Section::make('Archivos Adjuntos')
                    ->schema([
                        FileUpload::make('file')
                            ->label('Adjuntar Documento')
                            ->multiple()
                            ->directory('documents')
                            ->maxFiles(5)
                            ->maxSize(10240) // Tamaño máximo en KB (10 MB
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'image/jpeg',
                                'image/png',
                            ])
                            ->downloadable()
                            ->openable()
                            ->previewable()
                            ->reorderable()
                            ->columnSpanFull()
                            ->helperText('Tipos de archivo permitidos: PDF, Word, Excel, JPG, PNG. Tamaño máximo por archivo: 10 MB.'),
                    ]),
            ]);
    }
}
