<?php

declare(strict_types=1);

namespace App\Actions\Documents;

use App\Models\Document;
use App\Models\DocumentFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class StoreDocumentFilesAction
{
    private const STORAGE_DISK = 'public';
    private const STORAGE_DIRECTORY = 'documents';
    public function execute(Document $document, array $files): void
    {
        foreach ($files as $file) {
            if (!$file instanceof TemporaryUploadedFile) {
                continue;
            }
            $this->storeFile($document, $file);
        }
    }
    private function storeFile(Document $document, TemporaryUploadedFile $file): DocumentFile
    {
        $filename = $this->generateUniqueFilename($file);
        $path = $file->storeAs(
            self::STORAGE_DIRECTORY,
            $filename,
            self::STORAGE_DISK
        );

        return DocumentFile::create([
            'document_id' => $document->id,
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
        ]);
    }
    private function generateUniqueFilename(TemporaryUploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        return Str::uuid() . '_' . time() . '.' . $extension;
    }
}
