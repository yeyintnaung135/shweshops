<?php


namespace App\Helpers;
use Request;
use App\Shopowner;
use Illuminate\Support\Facades\Auth;
use App\BackroleLogActivity as BackroleLogActivityModel;


class BackroleLogActivity
{


    public static function BackroleDeleteLog($subject,$shop_id)
    {
    	$log = [];
		if(isset(Auth::guard('shop_owner')->user()->id)){
		    $log['shop_id'] = Auth::guard('shop_owner')->check() ? auth()->user()->id : 0;
    	}elseif(isset(Auth::guard('shop_role')->user()->id)){
    	   $log['shop_id'] =  $shop_id;
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
    	$log['action'] = 'delete';
    	$log['name'] = $subject->name;
        $role = $subject->role_id;

        if($role == 1){
            $log['role'] = 'admin';
        }elseif($role == 2){
            $log['role'] = 'manager';
        }elseif($role == 3){
            $log['role'] = 'staff';
        }else{
            $log['role'] = 'shopowner';
        }
    	BackroleLogActivityModel::create($log);
    }

    public static function BackroleCreateLog($subject,$shop_id)
    {
        // return dd($subject);
    	$log = [];
		if(isset(Auth::guard('shop_owner')->user()->id)){
		    $log['shop_id'] = Auth::guard('shop_owner')->check() ? auth()->user()->id : 0;
    	}elseif(isset(Auth::guard('shop_role')->user()->id)){
    	   $log['shop_id'] =  $shop_id;
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
    	$log['action'] = 'create';
    	$log['name'] = $subject['name'];
        $role = $subject['role_id'];

        if($role == 1){
            $log['role'] = 'admin';
        }elseif($role == 2){
            $log['role'] = 'manager';
        }elseif($role == 3){
            $log['role'] = 'staff';
        }else{
            $log['role'] = 'shopowner';
        }
    	BackroleLogActivityModel::create($log);
    }


    public static function BackroleEditLog($subject,$shop_id)
    {
    	$log = [];
		if(isset(Auth::guard('shop_owner')->user()->id)){
		    $log['shop_id'] = Auth::guard('shop_owner')->check() ? auth()->user()->id : 0;
    	}elseif(isset(Auth::guard('shop_role')->user()->id)){
    	    $log['shop_id'] =  $shop_id;
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
    	$log['action'] = 'edit';
    	$log['name'] = $subject['name'];
        $role = $subject['role_id'];

        if($role == 1){
            $log['role'] = 'admin';
        }elseif($role == 2){
            $log['role'] = 'manager';
        }elseif($role == 3){
            $log['role'] = 'staff';
        }else{
            $log['role'] = 'shopowner';
        }
    	$backroleid = BackroleLogActivityModel::create($log);
        return $backroleid;
    }


    public static function logActivityLists()
    {
    	return BackroleLogActivityModel::latest()->get();
    }


}
