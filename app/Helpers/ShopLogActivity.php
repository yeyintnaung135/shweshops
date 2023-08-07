<?php


namespace App\Helpers;
use Request;
use App\Shopowner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\ShopLogActivity as ShopLogActivityModel;


class ShopLogActivity
{


  

    // public static function shopaddToLog($shop)
    // {
		
    // 	$log = [];
		
    // 	$log['shop'] = $shop;
    // 	$log['url'] = Request::fullUrl();
    // 	$log['method'] = Request::method();
    // 	$log['ip'] = Request::ip();
    // 	$log['agent'] = Request::header('user-agent');
    // 	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    // 	$log['guest_id'] = Session::get('guest_id');
    // 	ShopLogActivityModel::create($log);
    // }

    public static function shopidaddToLog($shop)
    {
		
    	$log = [];
    	$log['shop'] = $shop->id;
    	$log['shop_name'] = $shop->name;
    	 if(isset(Auth::guard('web')->user()->id)){
            $log['user_name'] =  auth()->check() ? auth()->user()->username : 0;
        }else{
            $log['user_name'] = 'guest';
        }
    	
        if(isset(Auth::guard('web')->user()->id)){
            $log['user_id'] =  auth()->check() ? auth()->user()->id : 0;
        }else{
            $log['user_id'] =  Session::get('guest_id');
        }
    	ShopLogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
    	return ShopLogActivityModel::latest()->get();
    }


}