<?php


namespace App\Helpers;
use Request;
use App\Shopowner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\WhislistClickLog as WhislistClickLogModel;


class WhislistClickLog
{


    public static function WhislistClickLog($subject)
    {
		
    	$log = [];
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
    	$log['shop_id'] = $subject->shop_id;
        WhislistClickLogModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get(); 
    }


}