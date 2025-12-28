<?php

declare(strict_types=1);

use App\Jobs\ProcessDocumentFile;
use App\Models\Administration;
use App\Models\Customer;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

it('attaches files and dispatches processing job', function () {
    Storage::fake('public');
    Bus::fake();

    $user = User::factory()->create();
    $this->actingAs($user);

    $customer = Customer::factory()->create();
    $docType = DocumentType::create(['code' => 'T' . uniqid(), 'name' => 'Tipo 1', 'requires_response' => false, 'response_days' => null, 'status' => true]);
    $office = Office::create(['code' => 'O' . uniqid(), 'name' => 'Mesa de Partes', 'acronym' => 'MDP', 'level' => 1, 'status' => true]);
    $admin = Administration::create(['name' => 'Gestion 1', 'start_period' => now(), 'end_period' => now()->addYear(), 'mayor' => 'Alcalde', 'status' => true]);

    $document = Document::create([
        'customer_id' => $customer->id,
        'document_number' => 'DOC-' . uniqid(),
        'case_number' => 'CASE-' . uniqid(),
        'subject' => 'Prueba',
        'origen' => 'Externo',
        'document_type_id' => $docType->id,
        'area_origen_id' => $office->id,
        'gestion_id' => $admin->id,
        'user_id' => null,
        'reception_date' => now()->toDateString(),
        'status' => 'Registrado',
    ]);

    $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

    app(\App\Services\DocumentService::class)->attachFiles($document, [$file]);

    $this->assertDatabaseHas('document_files', [
        'document_id' => $document->id,
        'original_filename' => 'document.pdf',
    ]);

    Bus::assertDispatched(ProcessDocumentFile::class);
});
