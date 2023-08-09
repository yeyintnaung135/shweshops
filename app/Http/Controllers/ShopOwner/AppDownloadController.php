<?php

namespace App\Http\Controllers\ShopOwner;

use App\Models\AppFile;
use App\Http\Controllers\Controller;

class AppDownloadController extends Controller
{
    //NOTE return view for android apk
    public function android()
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
        $filepath = storage_path('app/app_files/' . $appFile->file);

        // $filename = 'ShweShop.apk';
        // $filepath = storage_path('app/app_files/' . $filename); // Static Download

        if (file_exists($filepath)) {
            return response()->download($filepath, $appFile->file);
        } else {
            return redirect()->route('backside.shop_owner.app-files.android')->with('error', 'File not found.');
        }
    }

}
