<?php


namespace App\Helpers;
use Request;
use App\Shopowner;
use App\Item;
use Illuminate\Support\Facades\Auth;
use App\MultipleDamageLogs as MultipleDamageLogsModel;


class MultipleDamageLogs
{


    public static function MultipleDamageLogs($subject,$old_percent,$shop_id)
    {    

		// return dd($subject);
    	$log = [];
        if(isset(Auth::guard('shop_owner')->user()->id)){
		    $log['shop_id'] = Auth::guard('shop_owner')->check() ? auth()->user()->id : 0;
    	}elseif(isset(Auth::guard('shop_role')->user()->id)){
    	   $log['shop_id'] = $shop_id;
    	}
        $log['item_id'] = $subject->id;
        if(isset(Auth::guard('shop_role')->user()->id)){
    	    $log['user_name'] = Auth::guard('shop_role')->user()->name;
        }else{
            $log['user_name'] = Auth::guard('shop_owner')->user()->name;
        }
        if(isset(Auth::guard('shop_owner')->user()->id)){
    	    $log['user_role'] = 'shopowner';
        }elseif(isset(Auth::guard('shop_role')->user()->id)){
            if(Auth::guard('shop_role')->user()->role_id == 1){
                $log['user_role'] = 'admin';
            }elseif(Auth::guard('shop_role')->user()->role_id == 2){
                $log['user_role'] = 'manager';
            }elseif(Auth::guard('shop_role')->user()->role_id == 3){
                $log['user_role'] = 'staff';
            }
        }
    	$log['name'] = $subject->name;
    	$log['product_code'] = $subject->product_code;
    	$log['new_decrease'] = $old_percent->အလျော့တွက်;
    	$log['new_fee'] = $old_percent->လက်ခ; 
        $log['new_undamage'] = $old_percent->အထည်မပျက်ပြန်သွင်း; 
        $log['new_damage'] = $old_percent->အထည်ပျက်စီးချို့ယွင်း; 
        $log['new_expensive_thing'] = $old_percent->တန်ဖိုးမြင့်; 
    	$log['decrease'] = $subject->handmade;
    	$log['fee'] = $subject->charge; 
        $log['undamage'] = $subject->အထည်မပျက်_ပြန်သွင်း; 
        $log['damage'] = $subject->အထည်ပျက်စီးချို့ယွင်း; 
        $log['expensive_thing'] = $subject->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ; 
        
    	
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	MultipleDamageLogsModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get(); 
    }


}