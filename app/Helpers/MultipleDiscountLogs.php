<?php


namespace App\Helpers;
use Request;
use App\Shopowner;
use App\Item;
use Illuminate\Support\Facades\Auth;
use App\MultipleDiscountLogs as MultipleDiscountLogsModel;


class MultipleDiscountLogs
{


    public static function MultipleDiscountLogs($p,$discount,$olddiscount,$shop_id)
    {


    	$log = [];
        if(isset(Auth::guard('shop_owner')->user()->id)){
		    $log['shop_id'] = Auth::guard('shop_owner')->user()->id;
    	}elseif(isset(Auth::guard('shop_role')->user()->id)){
    	   $log['shop_id'] = $shop_id;
    	}
        $log['item_id'] = $p->id;
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
    	$log['name'] = $p->name;
    	$log['product_code'] = $p->product_code;
    	if($p->min_price>0){
            $log['old_price'] = "-----";
        }else{
            $log['old_price'] = $p->price;
        }

        if( $p->price>0){
            $log['old_min_price'] = "-----";
    	    $log['old_max_price'] = "-----";
        }else{
            $log['old_min_price'] = $p->min_price;
    	    $log['old_max_price'] = $p->max_price;
        }
    	$log['percent'] =  $discount->percent;
        foreach($olddiscount as $olddiscount){

            if($p->min_price>0){
                $log['old_discount_price'] = "-----";
            }elseif($discount->discount_price === 0){
                $log['old_discount_price'] = "-----";
            }else{
                $log['old_discount_price'] = $olddiscount->discount_price;
            }

            if($p->price>0){
                $log['old_discount_min'] = "-----";
                $log['old_discount_max'] = "-----";
            }elseif($discount->discount_min === 0){
                $log['old_discount_min'] = "-----";
                $log['old_discount_max'] = "-----";
            }else{
                $log['old_discount_min'] = $olddiscount->discount_min;
                $log['old_discount_max'] = $olddiscount->discount_max;
            }

        }

        if($p->min_price>0){
            $log['new_discount_price'] = "-----";
        }elseif($discount->discount_price === 0){
            $log['new_discount_price'] = "-----";
        }else{
            $log['new_discount_price'] =  $discount->discount_price;
        }

        if($p->price>0){
            $log['new_discount_min'] =  "-----";
            $log['new_discount_max'] =  "-----";
        }elseif($discount->discount_min === 0){
            $log['new_discount_min'] =  "-----";
            $log['new_discount_max'] =  "-----";
        }else{
            $log['new_discount_min'] =  $discount->discount_min;
            $log['new_discount_max'] =  $discount->discount_max;
        }



    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	MultipleDiscountLogsModel::create($log);
    }

    public static function MultipleNoneDiscountLogs($p,$discount,$olddiscount,$shop_id)
    {



    	$log = [];

        if(isset(Auth::guard('shop_owner')->user()->id)){
		    $log['shop_id'] = Auth::guard('shop_owner')->user()->id;
    	}elseif(isset(Auth::guard('shop_role')->user()->id)){
    	   $log['shop_id'] = $shop_id;
    	}
        $log['item_id'] = $p->id;
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
    	$log['name'] = $p->name;
    	$log['product_code'] = $p->product_code;
        if($p->min_price>0){
            $log['old_price'] = "-----";
        }else{
            $log['old_price'] = $p->price;
        }

        if( $p->price>0){
            $log['old_min_price'] = "-----";
    	    $log['old_max_price'] = "-----";
        }else{
            $log['old_min_price'] = $p->min_price;
    	    $log['old_max_price'] = $p->max_price;
        }

    	$log['percent'] =  $discount->percent;
        foreach($olddiscount as $olddiscount){
            if($p->min_price>0){
                $log['old_discount_price'] = "-----";
            }elseif($discount->discount_price === 0){
                $log['old_discount_price'] = "-----";
            }else{
                $log['old_discount_price'] = $olddiscount->discount_price;
            }

            if($p->price>0){
                $log['old_discount_min'] = "-----";
                $log['old_discount_max'] = "-----";
            }elseif($discount->discount_min === 0){
                $log['old_discount_min'] = "-----";
                $log['old_discount_max'] = "-----";
            }else{
                $log['old_discount_min'] = $olddiscount->discount_min;
                $log['old_discount_max'] = $olddiscount->discount_max;
            }
        }

        if($p->min_price>0){
            $log['new_discount_price'] = "-----";
        }else{
            $log['new_discount_price'] =  $discount->discount_price;
        }


        if($p->price>0){
            $log['new_discount_min'] =  "-----";
            $log['new_discount_max'] =  "-----";
        }elseif($discount->discount_min === 0){
            $log['new_discount_min'] =  "-----";
            $log['new_discount_max'] =  "-----";
        }else{
            $log['new_discount_min'] =  $discount->discount_min;
            $log['new_discount_max'] =  $discount->discount_max;
        }


    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	MultipleDiscountLogsModel::create($log);
    }




    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}
