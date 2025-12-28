<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\Documents\CreateDocumentAction;
use App\Models\Administration;
use App\Models\Customer;
use App\Models\Document;
use App\Models\DocumentFile;
use App\Models\DocumentType;
use App\Models\Office;
use Asmit\FilamentUpload\Enums\PdfViewFit;
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DocumentProcedureForm extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Registre tramite')
                    ->description(' registre su tramite llene los campos requeridos para registrar su tramite')
                    ->schema([
                        Fieldset::make('Datos del Tramite')
                            ->schema([
                                Select::make('customer_id')
                                    ->label('Cliente')
                                    ->options(Customer::all()->mapWithKeys(
                                        fn($client) => [
                                            $client->id => trim("{$client->dni} " . ($client->ruc ? "  {$client->ruc}" : '')),
                                        ],
                                    ))
                                    ->searchable(['full_name', 'dni', 'ruc'])
                                    ->preload()
                                    ->live()
                                    ->native(false)
                                    ->createOptionForm(
                                        $this->customerForm()
                                    )
                                    ->createOptionUsing(function (array $data) {
                                        $customer = Customer::create($data);

                                        return $customer->id;
                                    })
                                    ->columnSpanFull(),
                                TextInput::make('document_number')
                                    ->label('Numero de documento')
                                    ->prefix('EXT-')
                                    ->unique(ignoreRecord: true)
                                    ->default(function () {
                                        return $this->getNextSequentialNumber('document_number');
                                    })
                                    ->disabled()
                                    ->dehydrated(),
                                TextInput::make('case_number')
                                    ->label('Numero de expediente')
                                    ->prefix('EXP-')
                                    ->unique(ignoreRecord: true)
                                    ->default(function () {
                                        return $this->caseNumber('case_number');
                                    })
                                    ->disabled()
                                    ->dehydrated(),
                                Select::make('origen')
                                    ->options([
                                        'Interno' => 'Interno',
                                        'Externo' => 'Externo',
                                    ])
                                    ->default('Externo')
                                    ->disabled()
                                    ->dehydrated(),
                                Select::make('status')
                                    ->options([
                                        'Registrado' => 'Registrado',
                                        'En Proceso' => 'En Proceso',
                                        'Completado' => 'Completado',
                                        'Archivado' => 'Archivado',
                                    ])
                                    ->default('Registrado')
                                    ->disabled()
                                    ->dehydrated(),
                                Textarea::make('subject')
                                    ->label('Asunto')
                                    ->required()
                                    ->columnSpanFull(),
                                Select::make('document_type_id')
                                    ->label('Tipo de documento')
                                    ->options(DocumentType::where('status', true)->pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->native(false),
                                Select::make('area_origen_id')
                                    ->label('Area de origen')
                                    ->options(Office::where('status', true)->pluck('name', 'id'))
                                    ->default(function () {
                                        $officeId = Office::where('status', true)
                                            ->whereRaw('LOWER(name) = ?', ['mesa de partes'])
                                            ->value('id');

                                        if ($officeId) {
                                            return $officeId;
                                        }

                                        return Office::where('status', true)->value('id');
                                    })
                                    ->searchable()
                                    ->required()
                                    ->disabled()
                                    ->dehydrated(),

                                Select::make('gestion_id')
                                    ->label('Gestion')
                                    ->options(Administration::where('status', true)->pluck('name', 'id'))
                                    ->default(function () {
                                        return Administration::where('status', true)->value('id');
                                    })
                                    ->disabled()
                                    ->dehydrated(),
                                TextInput::make('folio')
                                    ->label('Folio'),
                                DatePicker::make('reception_date')
                                    ->label('Fecha de recepcion')
                                    ->default(now())
                                    ->required()
                                    ->disabled()
                                    ->dehydrated(),
                                DatePicker::make('response_deadline')
                                    ->label('Fecha limite de respuesta'),

                            ])->columnSpan(2),
                        Fieldset::make('documento')
                            ->schema([
                                AdvancedFileUpload::make('files')
                                    ->label('Upload PDF')
                                    ->storeFiles(false) // 🔴 OBLIGATORIO
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

                            ])->columnSpan(2),
                        Checkbox::make('condition')
                            ->label(
                                'Acepto que todo acto administrativo derivado del presente procedimiento se me
                                            notifique a mi correo electrónico (numeral 4 del artículo 20° del Texto Único
                                            Ordenado de la Ley N° 27444)',
                            )
                            ->required()
                            ->rule('required')
                            ->columnSpanFull(),
                    ])->columns(4),
            ])

            ->statePath('data');
    }
    public function create(CreateDocumentAction $action): void
    {
        try {
            $data = $this->form->getState();
            $action->execute($data);
            session()->flash('success', 'Documento registrado exitosamente.');

            $this->form->fill();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al registrar el documento: ' . $e->getMessage());
        }

        // $record = Document::create($data);
        // $this->form->model($record)->saveRelationships();
    }

    private function getNextSequentialNumber(string $field): string
    {
        $year = now()->year;
        $prefix = "{$year}-";
        $lastDocument = Document::where($field, 'like', "{$prefix}%")
            ->orderBy($field, 'desc')
            ->first();
        $lastNumber = $lastDocument
            ? (int) str_replace($prefix, '', $lastDocument->$field)
            : 0;
        $nexNumber = $lastNumber + 1;

        return sprintf('%s%04d', $prefix, $nexNumber);
    }

    private function caseNumber(): string
    {
        $year = now()->year;

        // Generate a 5-digit random number that always starts with 0 (00001–09999)
        $sequence = str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        $randomNumber = "0{$sequence}";

        return "{$year}-{$randomNumber}";
    }

    private function customerForm()
    {
        return [
            ToggleButtons::make('representation')
                ->label('Representante')
                ->boolean(trueLabel: 'Persona Natura', falseLabel: 'Persona Juridica')
                ->icons(['heroicon-o-briefcase', 'heroicon-o-user'])
                ->live()
                ->grouped()
                ->default(true),
            Fieldset::make('Persona Natural')
                ->visible(fn($get) => $get('representation') === true)
                ->schema([TextInput::make('dni')->label('DNI')->required(), TextInput::make('full_name')->label('Nombre')->required()->requiredWith('representation'), TextInput::make('last_name')->label('Apellido paterno')->required()->requiredWith('representation'), TextInput::make('first_name')->label('Apellido materno')->required()->requiredWith('representation')]),
            Fieldset::make('Persona Juridica')
                ->visible(fn($get) => $get('representation') === false)
                ->schema([TextInput::make('ruc')->requiredWith('representation'), TextInput::make('company')->requiredWith('representation')]),
        ];
    }

    public function render()
    {
        return view('livewire.document-procedure-form');
    }
}
