<?php


namespace App\Helpers;
use Request;
use App\Shopowner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\ItemLogActivity as ItemLogActivityModel;


class ItemLogActivity
{


    public static function ItemaddToLog($item)
    {
    	$log = [];
    // 	$itemid = $item->id;
    //   	return dd($item);
        $log['item_id'] = $item->	id;
        $log['shop_id'] = $item->	shop_id;
    	$log['item_code'] = $item->	product_code;
        $log['name'] = $item->name;
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
    	ItemLogActivityModel::create($log);
    }





    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}
