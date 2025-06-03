<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{

    public function upload(UploadedFile $file, string $folder): ?string
    {
        try {

            $folder = Str::slug($folder);

            $uniqueFileName = Str::uuid() . '.' . $file->getClientOriginalExtension();


            // Define the upload directory
            $uploadPath = public_path('uploads/' . $folder);


            if (!file_exists($uploadPath)) {
                if (!mkdir($uploadPath, 0775, true) && !is_dir($uploadPath)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $uploadPath));
                }
            }

            // Check if directory is writable
            if (!is_writable($uploadPath)) {
                throw new \RuntimeException('Upload path is not writable: ' . $uploadPath);
            }

            // Move the file to the directory
            $file->move($uploadPath, $uniqueFileName);
            Log::info('File successfully moved to: ' . $uploadPath . '/' . $uniqueFileName);

            // Return the public URL for the uploaded file
            $uploadedFilePath = asset('uploads/' . $folder . '/' . $uniqueFileName);
            Log::info('Uploaded file URL: ' . $uploadedFilePath);

            return $uploadedFilePath;
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('File upload failed: ' . $e->getMessage());
            return null;
        }
    }
}
