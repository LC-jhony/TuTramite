<?php

declare(strict_types=1);

namespace App\Actions\Documents;

use App\Models\Document;
use Illuminate\Support\Facades\DB;


class CreateDocumentAction
{
    public function __construct(
        private readonly StoreDocumentFilesAction $storeFilesAction
    ) {}

    public function execute(array $data): Document
    {
        return DB::transaction(function () use ($data) {
            // Extraer archivos del array principal
            $files = $data['files'] ?? [];
            unset($data['files']);

            // Crear el documento
            $document = Document::create($data);

            // Guardar los archivos si existen
            if (!empty($files)) {
                $this->storeFilesAction->execute($document, $files);
            }

            return $document;
        });
    }
}
