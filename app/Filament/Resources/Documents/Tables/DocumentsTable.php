<?php

declare(strict_types=1);

namespace App\Filament\Resources\Documents\Tables;

use App\Models\Document;
use App\Models\Office;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->searchable()
            ->columns([
                // TextColumn::make('client')
                //     ->label('Cliente')
                //     ->getStateUsing(fn ($record) => $record->client ? $record->client->dni.' '.$record->client->ruc : ''),
                TextColumn::make('document_number')
                    ->label('Numero'),
                TextColumn::make('case_number')
                    ->label('Caso'),
                // TextColumn::make('subject'),
                TextColumn::make('origen')
                    ->label('Origén')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Interno' => 'info',
                        'Externo' => 'danger',
                    }),
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
                ActionGroup::make([
                    Action::make('derivar')
                        ->label('Derivar')
                        ->icon(Heroicon::ArrowRightCircle)
                        ->color('danger')
                        ->form([
                            Select::make('destination_office_id')
                                ->label('Oficina Destino')
                                ->options(Office::where('status', true)->pluck('name', 'id'))
                                ->searchable()
                                ->native(false)
                                ->afterStateUpdated(function ($state, Set $set) {
                                    $set('destination_user_id', null); // Clear first
                                    if ($state) { // If an office is selected
                                        $firstUser = User::where('office_id', $state)->first();
                                        $set('destination_user_id', $firstUser?->id);
                                    }
                                })
                                ->live(),
                            Select::make('destination_user_id')
                                ->label('Usuario Destino')
                                ->reactive()
                                ->options(
                                    fn (callable $get) => User::where('office_id', $get('destination_office_id'))->pluck('name', 'id')->toArray()
                                )
                                ->searchable()
                                ->preload(false),
                            Textarea::make('indication')
                                ->label('Indicación'),
                        ])
                        ->slideOver()
                        ->action(function (Document $record, array $data) {
                            $record->movements()->create([
                                'document_id',
                                'origin_office_id' => $record->id_office_destination,
                                'origin_user_id' => Auth::id(),
                                'destination_office_id' => $data['destination_office_id'],
                                'destination_user_id' => $data['destination_user_id'],
                                'action' => 'DERIVACION',
                                'indication' => $data['indication'],
                                'observation' => $data['observation'],
                                'receipt_date' => $data['receipt_date'],
                                'status' => 'ENVIADO',
                            ]);
                        }),
                    Action::make('atender')
                        ->label('atender')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation(),
                ])
                    ->label('More actions')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size(Size::Small)
                    ->color('primary')
                    ->button(),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at')
            ->poll('30s');
    }
}
