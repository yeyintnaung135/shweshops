<?php


namespace App\Helpers;
use Request;
use App\Shopowner;
use App\Item;
use Illuminate\Support\Facades\Auth;
use App\MultiplePriceLogs as MultiplePriceLogsModel;


class MultiplePriceLogs
{


    public static function MultiplePlusPriceLogs($subject,$plus_price,$shop_id)
    {   

		// return dd($plus_price);
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
        if($subject->min_price > 0){
            $log['old_price'] = "-----"; 
            $log['new_price'] = "-----"; 
        }else{
            $log['old_price'] = $subject->price; 
            $log['new_price'] = $subject->price + $plus_price; 
        }

        if( $log['old_price'] > 0){
            $log['min_price'] = "-----"; 
            $log['max_price'] = "-----"; 
            $log['new_min_price'] = "-----" ; 
            $log['new_max_price'] = "-----"; 
        }else{
            $log['min_price'] = $subject->min_price; 
            $log['max_price'] = $subject->max_price; 
            $log['new_min_price'] = $subject->min_price + $plus_price; 
            $log['new_max_price'] = $subject->max_price + $plus_price; 
        }
       
        
    	
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	MultiplePriceLogsModel::create($log);
    }

    public static function MultipleMinusPriceLogs($subject,$plus_price,$shop_id)
    {
		// return dd($subject->price);
    
            $log = [];
            if(isset(Auth::guard('shop_owner')->user()->id)){
                $log['shop_id'] = Auth::guard('shop_owner')->check() ? auth()->user()->id : 0;
            }elseif(isset(Auth::guard('shop_role')->user()->id)){
            $log['shop_id'] = $shop_id;
            }
            
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

        
            
            $log['item_id'] = $subject->id;
            $log['name'] = $subject->name;
            $log['product_code'] = $subject->product_code;
            if($subject->min_price > 0){
                $log['old_price'] = "-----"; 
                $log['new_price'] = "-----"; 
            }else{
                $log['old_price'] = $subject->price; 
                $log['new_price'] = $subject->price - $plus_price; 
            }
    
            if( $log['old_price'] > 0){
                $log['min_price'] = "-----"; 
                $log['max_price'] = "-----"; 
                $log['new_min_price'] = "-----" ; 
                $log['new_max_price'] = "-----"; 
            }else{
                $log['min_price'] = $subject->min_price; 
                $log['max_price'] = $subject->max_price; 
                $log['new_min_price'] = $subject->min_price - $plus_price; 
                $log['new_max_price'] = $subject->max_price - $plus_price; 
            }
            
            
            $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
            

            MultiplePriceLogsModel::create($log);
        
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get(); 
    }


}