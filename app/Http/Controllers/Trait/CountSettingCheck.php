<?php

namespace App\Http\Controllers\Trait;

use App\Models\CountSetting;

trait CountSettingCheck{

    public function checkUserCount($id)
    {
        $users = CountSetting::where('shop_id' , $id)->get();
        return $users;

    }
    public function shopViewCheck($id)
    {
       return CountSetting::where('shop_id', $id)->where('name','shop_view')->get();

    }
    public function uniqueProductViewCheck($id)
    {
       return CountSetting::where('shop_id', $id)->where('name','item_unique_view')->get();

    }
    public function buyNowClickViewCheck($id)
    {
       return CountSetting::where('shop_id',$id)->where('name','buyNowClick')->get();

    }
    public function uniqueAddToCartViewCheck($id)
    {
       return  CountSetting::where('shop_id',$id)->where('name','addToCartClick')->get();

    }

    public function uniqueWhishlistViewCheck($id)
    {
       return  CountSetting::where('shop_id',$id)->where('name','whislistclick')->get();

    }
    public function uniqueAdsViewCheck($id)
    {
       return  CountSetting::where('shop_id',$id)->where('name','adsview')->get();

    }
    public function uniqueDiscountCheck($id)
    {
       return  CountSetting::where('shop_id',$id)->where('name','discountview')->get();

    }

}
