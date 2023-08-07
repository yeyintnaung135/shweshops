<?php


namespace App\Helpers;
use Request;
use App\Shopowner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\VisitorLogActivity as VisitorLogActivityModel;


class VisitorLogActivity
{


    public static function VisitorLogActivity($subject)
    {
    	$log = [];
        // if(Session::has('guest_id')){
        //     return dd("haha");
        // };

        $data=Session::all();
        // return dd($data);
       
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

        
    	
    	VisitorLogActivityModel::create($log);
    }


   

}