<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileUpload
{
    /**
     * Handle file upload with automatic old file deletion
     *
     * @param UploadedFile|null $file
     * @param string|null $oldFile
     * @param string $path
     * @param string $disk
     * @return string|null
     */
    protected function handleFileUpload(?UploadedFile $file, ?string $oldFile, string $path, string $disk = 'upload'): ?string
    {
        if (!$file) {
            return null;
        }

        // Delete old file if exists
        if ($oldFile) {
            Storage::disk($disk)->delete($oldFile);
        }

        // Store new file
        return $file->store($path, $disk);
    }
}
