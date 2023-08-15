<?php

namespace App\Http\Controllers\ShopOwner;

use File;
use App\Models\MainPopup;
use App\Models\ShopOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Trait\UserRole;


class PopupAdsController extends Controller
{
    use UserRole;

    public function main_popup()
    {
        $current_shop = $this->get_shopid();

        $popup = MainPopup::where('shop_id', $current_shop)->first();
        return view('backend.shopowner.ads.main_popup', ["shop_id" => $current_shop, "popup" => $popup]);
    }

    public function main_popup_upload(Request $request)
    {
        $current_shop = $this->get_shopid();

        $this->validate($request, [
            'video' => 'required|file|mimetypes:video/mp4',
        ]);
        $checkExist = MainPopup::where('shop_id', $current_shop)->first();
        // dd($checkExist);
        if ($checkExist) {
            MainPopup::where('shop_id', $current_shop)->delete();
            File::delete($checkExist->video_path);
        }
        $file = $request->file('video');
        $fileName = $request->video->getClientOriginalName();
        $filePath = 'test/video/' . $fileName;
        $shop_id = $current_shop;
        $ad_title = $request->adTitle;
        $isFileUploaded = $file->move(public_path('test/video/'), $fileName);;

        // File URL to access the video in frontend
        // $url = Storage::disk('public')->url($filePath);
        // dd($fileName." ".$filePath." ".$isFileUploaded." ".$url." ".$shop_id);
        if ($isFileUploaded) {
            $video = new MainPopup();
            $video->ad_title = $ad_title;
            $video->video_name = $fileName;
            $video->video_path = $filePath;
            $video->shop_id = $shop_id;
            $video->save();
            return back()->with('success', 'Video has been successfully uploaded!');
        }

        return back()->with('error', 'Unexpected error occured');
    }

    public function main_popup_delete()
    {
        $current_shop = $this->get_shopid();
        $video = MainPopup::where('shop_id', $current_shop)->first();
        MainPopup::where('shop_id', $current_shop)->delete();
        File::delete($video->video_path);
        return back()->with('success', 'Video deleted successfully!');
    }
}
