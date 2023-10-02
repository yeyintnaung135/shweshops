<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\UserRole;
use App\Models\MainPopup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PopupAdsController extends Controller
{
    use UserRole;

    public function main_popup(): View
    {
        $current_shop = $this->get_shopid();

        $popup = MainPopup::where('shop_id', $current_shop)->first();
        return view('backend.shopowner.ads.main_popup', ["shop_id" => $current_shop, "popup" => $popup]);
    }

    public function main_popup_upload(Request $request): RedirectResponse
    {
        $current_shop = $this->get_shopid();

        $this->validate($request, [
            'video' => 'required|file|mimetypes:video/mp4',
        ]);

        $useDigitalOcean = env('USE_DO') == 'true';

        $checkExist = MainPopup::where('shop_id', $current_shop)->first();

        if ($checkExist) {
            // Delete existing file and database record
            if ($useDigitalOcean) {
                Storage::disk('digitalocean')->delete($checkExist->video_path);
            } else {
                File::delete(public_path($checkExist->video_path));
            }
            $checkExist->delete();
        }

        $file = $request->file('video');
        $fileName = $request->video->getClientOriginalName();
        $filePath = $useDigitalOcean ? 'prod/videos/' . $fileName : 'images/videos/' . $fileName;
        $shop_id = $current_shop;
        $ad_title = $request->adTitle;

        // Move the file to the public folder
        if ($useDigitalOcean) {
            Storage::disk('digitalocean')->put($filePath, file_get_contents($file), 'public');
        } else {
            $file->move(public_path($useDigitalOcean ? 'prod/videos/' : 'images/videos/'), $fileName);
        }

        // File URL to access the video in frontend
        $url = $useDigitalOcean ? Storage::disk('digitalocean')->url($filePath) : asset($filePath);

        $video = new MainPopup();
        $video->ad_title = $ad_title;
        $video->video_name = $fileName;
        $video->video_path = $filePath;
        $video->shop_id = $shop_id;
        $video->save();

        return back()->with('success', 'Video has been successfully uploaded!');
    }

    public function main_popup_delete(): RedirectResponse
    {
        $current_shop = $this->get_shopid();
        $video = MainPopup::where('shop_id', $current_shop)->first();

        if ($video) {

            // Determine storage disk based on USE_DO
            $useDigitalOcean = env('USE_DO') == 'true';

            if ($useDigitalOcean) {
                // Delete the file from DigitalOcean Spaces
                Storage::disk('digitalocean')->delete($video->video_path);
            } else {
                // Delete from the public folder
                File::delete(public_path($video->video_path));
            }

            $video->delete();

            return back()->with('success', 'Video deleted successfully!');
        }

        return back()->with('error', 'No video found to delete.');
    }

}
