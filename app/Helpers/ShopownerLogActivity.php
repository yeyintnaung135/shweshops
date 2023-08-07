<?php


namespace App\Helpers;
use Request;
use App\Shopowner;
use App\Manager;
use Illuminate\Support\Facades\Auth;
use App\ShopownerLogActivity as ShopownerLogActivityModel;


class ShopownerLogActivity
{


    public static function ShopownerDeleteLog($action,$shop_id)
    {
		
    	$log = [];
		if(isset(Auth::guard('shop_owner')->user()->id)){
		    $log['shop_id'] = Auth::guard('shop_owner')->check() ? auth()->user()->id : 0;
    	}elseif(isset(Auth::guard('shop_role')->user()->id)){
    	   $log['shop_id'] =  $shop_id;
    	}
    	$shop_name = Shopowner::where('id', $log['shop_id'])->get('name');	
    	
    	foreach($shop_name as $shop_name){
    	    	$log['shop_name'] = $shop_name->name ;
    	}
    	
    	foreach($action as $action){
	    	$log['item_id'] = $action->id;
    		$log['product_code'] = $action->product_code ;
    		$log['item_name'] = $action->name ;
    		$log['category'] = $action->category_id ;
    	}
    
    	$shop_name = Shopowner::where('id', $log['shop_id'])->get('name');	
    	
    	foreach($shop_name as $shop_name){
    	    	$log['shop_name'] = $shop_name->name ;
    	}
		$log['user_name'] =Auth::guard('shop_owner')->check() ? auth()->user()->name : 0;
    	$log['action'] = 'Delete';
		if(isset(Auth::guard('shop_owner')->user()->id)){
			$log['role'] = 'shopowner';
		}elseif(isset(Auth::guard('shop_role')->user()->id)){
			$log['user_name'] =Auth::guard('shop_role')->check() ? auth()->user()->name : 0;	
			if(Auth::guard('shop_role')->user()->role_id == 1){
				$log['role'] = 'admin';
			}elseif(Auth::guard('shop_role')->user()->role_id == 2){
				$log['role'] = 'manager';
			}elseif(Auth::guard('shop_role')->user()->role_id == 3){
				$log['role'] = 'staff';
			}	
		}
		
    	
		
    	ShopownerLogActivityModel::create($log);
    }

    public static function ShopownerCreateLog($action,$shop_id)
    {
		
    	$log = [];
		if(isset(Auth::guard('shop_owner')->user()->id)){
		    $log['shop_id'] = Auth::guard('shop_owner')->check() ? auth()->user()->id : 0;
    	}elseif(isset(Auth::guard('shop_role')->user()->id)){
    	   $log['shop_id'] =  $shop_id;
    	}
    	$shop_name = Shopowner::where('id', $log['shop_id'])->get('name');	
    	
    	foreach($shop_name as $shop_name){
    	    	$log['shop_name'] = $shop_name->name ;
    	}
		$log['item_id'] = $action->id;
		$log['product_code'] = $action->product_code ;
		$log['item_name'] = $action->name ;
		$log['category'] = $action->category_id ;
		$log['user_name'] =Auth::guard('shop_owner')->check() ? auth()->user()->name : 0;	
    	$log['action'] = 'Create';
		if(isset(Auth::guard('shop_owner')->user()->id)){
			$log['role'] = 'shopowner';
		}elseif(isset(Auth::guard('shop_role')->user()->id)){
			$log['user_name'] =Auth::guard('shop_role')->check() ? auth()->user()->name : 0;	
			if(Auth::guard('shop_role')->user()->role_id == 1){
				$log['role'] = 'admin';
			}elseif(Auth::guard('shop_role')->user()->role_id == 2){
				$log['role'] = 'manager';
			}elseif(Auth::guard('shop_role')->user()->role_id == 3){
				$log['role'] = 'staff';
			}	
		}
		
    	
		
    	ShopownerLogActivityModel::create($log);
    }

    public static function ShopownerEditLog($action,$shop_id)
    {
    	$log = [];
		if(isset(Auth::guard('shop_owner')->user()->id)){
		    $log['shop_id'] = Auth::guard('shop_owner')->check() ? auth()->user()->id : 0;
    	}elseif(isset(Auth::guard('shop_role')->user()->id)){
    	    $log['shop_id'] =  $shop_id;
    	}
    		$shop_name = Shopowner::where('id', $log['shop_id'])->get('name');	
    	
    	foreach($shop_name as $shop_name){
    	    	$log['shop_name'] = $shop_name->name ;
    	}
    	$log['item_id'] = $action->id;
		$log['product_code'] = $action->product_code ;
		$log['item_name'] = $action->name ;
		$log['category'] = $action->category_id ;
		$log['user_name'] =Auth::guard('shop_owner')->check() ? auth()->user()->name : 0;	
    	$log['action'] = 'Edit';
		if(isset(Auth::guard('shop_owner')->user()->id)){
			$log['role'] = 'shopowner';
		}elseif(isset(Auth::guard('shop_role')->user()->id)){
			$log['user_name'] =Auth::guard('shop_role')->check() ? auth()->user()->name : 0;	
			if(Auth::guard('shop_role')->user()->role_id == 1){
				$log['role'] = 'admin';
			}elseif(Auth::guard('shop_role')->user()->role_id == 2){
				$log['role'] = 'manager';
			}elseif(Auth::guard('shop_role')->user()->role_id == 3){
				$log['role'] = 'staff';
			}	
		}
		
    	
		
    	$shopownerlogid = ShopownerLogActivityModel::create($log);
		return $shopownerlogid;
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get(); 
    }


}