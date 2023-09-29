<?php

namespace App\Services;

use App\Models\AppFile;

//NOTE AppDownloadService is only responsible for downloading app files (apk, ipa)

class AppDownloadService
{
    public function download(AppFile $appFile)
    {
        $filepath = storage_path('app/app_files/' . $appFile->file);

        if (file_exists($filepath)) {
            return response()->download($filepath, $appFile->file);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
}
