<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Models\AppFile;
use App\Services\AppDownloadService;
use Illuminate\View\View;

class AppDownloadController extends Controller
{
    protected $appDownloadService;

    public function __construct(AppDownloadService $appDownloadService)
    {
        $this->appDownloadService = $appDownloadService;
    }

    //NOTE return view for android apk
    public function android(): View
    {
        $appFile = AppFile::where('user_type', 'Shop User')
            ->where('operating_system', 'Android')
            ->firstOrFail();

        return view('backend.shopowner.app-files.android', ['appFile' => $appFile]);
    }

    //TODO: implement view for iOS application if needed

    //NOTE download actual file
    public function download(AppFile $appFile)
    {
        return $this->appDownloadService->download($appFile);
    }
}
