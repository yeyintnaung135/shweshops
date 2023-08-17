<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

//NOTE ImageService is only responsible for image crud, if you want to resize image please refer to ykimage trait

class ImageService
{
    public function saveImage($file, $directory)
    {
        $timestamp = now()->format('YmdHis');
        $randomString = Str::random(10);
        $fileName = $timestamp . '_' . $randomString . '_' . $file->getClientOriginalName();
        $file->storeAs($directory, $fileName, 'public_image');

        return $fileName;
    }

    public function deleteImage($imagePath, $thumbnailPath)
    {
        $paths = [
            public_path('images/' . $imagePath),
            public_path('images/' . $thumbnailPath)
        ];

        File::delete($paths);
    }

    public function saveImageDigitalOcean($file, $directory)
    {
        $timestamp = now()->format('YmdHis');
        $randomString = Str::random(10);
        $fileName = $timestamp . '_' . $randomString . '_' . $file->getClientOriginalName();
        $file->storeAs($directory, $fileName, 'digitalocean');

        return $fileName;
    }

    public function deleteImageDigitalOcean($imagePath, $thumbnailPath)
    {
        $paths = [
            $imagePath,
            $thumbnailPath
        ];

        Storage::disk('digitalocean')->delete($paths);
    }
}
