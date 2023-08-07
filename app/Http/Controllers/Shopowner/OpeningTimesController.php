<?php

namespace App\Http\Controllers\Shopowner;

use File;
use App\OpeningTimes;
use App\Shopowner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OpeningTimesController extends Controller
{
    public function opening_times() {
        $current_shop = $this->getCurrentShopId();

        $openingTime = OpeningTimes::where('shop_id',$current_shop->id)->first();
        return view('backend.shopowner.opening_times.opening_times',["shop_id" => $current_shop->id, "opening_time" => $openingTime]);
    }

    public function opening_times_upload(Request $request) {
        $current_shop = $this->getCurrentShopId();

        $this->validate($request, [
            'opening_time' => 'required|string|max:200',
        ]);

        $checkExist = OpeningTimes::where('shop_id',$current_shop->id)->first();
        //dd($checkExist);
        if($checkExist){
            OpeningTimes::where('shop_id',$current_shop->id)->delete();
        }

        OpeningTimes::create([
            'opening_time' => $request->opening_time,
            'shop_id' => $request->shopId,
        ]);
    
        return back()->with('success','Opening time updated!');
    }

    public function opening_times_delete(){
        $current_shop = $this->getCurrentShopId();
        OpeningTimes::where('shop_id',$current_shop->id)->delete();
        return back()->with('success','Deleted successfully!');
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
