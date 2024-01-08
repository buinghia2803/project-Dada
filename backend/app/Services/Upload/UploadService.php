<?php

namespace App\Services\Upload;

class UploadService
{
    /**
     * Upload local file
     */
    public function uploadFile($file, $path = '')
    {
        $md5Name = md5_file($file->getRealPath());
        $guessExtension = $file->getClientOriginalExtension();
        $path = $file->storeAs($path, $md5Name . '.' . $guessExtension, 'public_uploads');
        return 'uploads/' . $path;
    }

    /**
     * Unlink
     */
    public function removeFile($url)
    {
        if (file_exists($url)) {
            unlink($url);
        }
    }
}
