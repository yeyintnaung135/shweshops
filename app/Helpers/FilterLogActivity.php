<?php


namespace App\Helpers;
use Request;
use App\Shopowner;
use Illuminate\Support\Facades\Auth;
use App\FilterLogActivity as FilterLogActivityModel;


class FilterLogActivity
{


    public static function FilteraddToLog($price)
    {
		
    	$log = [];
		
    	$log['price'] = $price;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	FilterLogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}