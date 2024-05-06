<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasFile
{
    // public $uploadDir = "public/files";

    /**
     * Upload and store the file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string|null
     */
    public function uploadFile(UploadedFile $file, $folder)
    {
        $_uploadDir = "public/files";

        $filename = $file->getClientOriginalName();
        $fileNameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        $fileExt = $file->getClientOriginalExtension();
        $newFileName = time().'_'.str_replace(' ','_', $fileNameWithoutExt).'.'.$fileExt;
        $file_path = $file->storeAs($folder ?? $this->uploadDir ?? $_uploadDir, $newFileName);
        
        return $file_path;
    }


    /**
     * Get the full URL of the file.
     *
     * @param string $path
     * @return string|null
     */
    public function getFileUrl($path)
    {
        if (Storage::exists($path)) {
            return Storage::url($path);
        }

        return null;
    }

    /**
     * Upload and stire a file to get the storage url
     */
    public function uploadAndStoreFile(UploadedFile $file, $folder=null){
        return $this->getFileUrl($this->uploadFile($file, $folder));
    }
}
