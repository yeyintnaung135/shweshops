<?php

namespace App\Http\Controllers\Shopowner;

use File;
use App\MainPopup;
use App\Shopowner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PopupAdsController extends Controller
{
    public function main_popup(){
        $current_shop = $this->getCurrentShopId();

        $popup = MainPopup::where('shop_id',$current_shop->id)->first();
        return view('backend.shopowner.ads.main_popup',["shop_id" => $current_shop->id, "popup" => $popup]);
    }

    public function main_popup_upload(Request $request){
        $current_shop = $this->getCurrentShopId();

        $this->validate($request, [
            'video' => 'required|file|mimetypes:video/mp4',
        ]);
        $checkExist = MainPopup::where('shop_id',$current_shop->id)->first();
        // dd($checkExist);
        if($checkExist){
            MainPopup::where('shop_id',$current_shop->id)->delete();
            File::delete($checkExist->video_path);
        }
        $file = $request->file('video');
        $fileName = $request->video->getClientOriginalName();
        $filePath = 'test/video/' . $fileName;
        $shop_id = $current_shop->id;
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
            return back()->with('success','Video has been successfully uploaded!');
        }

        return back()->with('error','Unexpected error occured');
    }

    public function main_popup_delete(){
        $current_shop = $this->getCurrentShopId();
        $video = MainPopup::where('shop_id',$current_shop->id)->first();
        MainPopup::where('shop_id',$current_shop->id)->delete();
        File::delete($video->video_path);
        return back()->with('success','Video deleted successfully!');
    }

    private function getCurrentShopId(){
        if(isset(Auth::guard('shop_owner')->user()->id)){
            $current_shop=Shopowner::where('id',Auth::guard('shop_owner')->user()->id)->first();
        }else{
            $manager= Manager::where('id', Auth::guard('shop_role')->user()->id)->pluck('shop_id');
            $current_shop=Shopowner::where('id',$manager)->first();
        }
        return $current_shop;
    }
}
