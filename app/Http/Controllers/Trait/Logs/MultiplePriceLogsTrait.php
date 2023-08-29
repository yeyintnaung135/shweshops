<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\LogActivity;
use App\Models\MultiplePriceLogs;
use Illuminate\Support\Facades\Auth;

trait MultiplePriceLogsTrait
{
    public static function MultiplePlusPriceLogs($subject, $plus_price, $shop_id)
    {

        // return dd($plus_price);
        $log = [];
        $log['shop_id'] = $shop_id;
        $log['item_id'] = $subject->id;
        $log['user_name'] = Auth::guard('shop_owners_and_staffs')->user()->name;

        $userRole = Auth::guard('shop_owners_and_staffs')->user()->role_id;
        switch ($userRole) {
            case 1:
                $log['user_role'] = 'admin';
                break;
            case 2:
                $log['user_role'] = 'manager';
                break;
            case 3:
                $log['user_role'] = 'staff';
                break;
            case 4:
                $log['user_role'] = 'shopowner';
                break;
            default:
                $log['user_role'] = 'unknown';
                break;
        }

        $log['name'] = $subject->name;
        $log['product_code'] = $subject->product_code;
        if ($subject->min_price > 0) {
            $log['old_price'] = "-----";
            $log['new_price'] = "-----";
        } else {
            $log['old_price'] = $subject->price;
            $log['new_price'] = $subject->price + $plus_price;
        }

        if ($log['old_price'] > 0) {
            $log['min_price'] = "-----";
            $log['max_price'] = "-----";
            $log['new_min_price'] = "-----";
            $log['new_max_price'] = "-----";
        } else {
            $log['min_price'] = $subject->min_price;
            $log['max_price'] = $subject->max_price;
            $log['new_min_price'] = $subject->min_price + $plus_price;
            $log['new_max_price'] = $subject->max_price + $plus_price;
        }

        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        MultiplePriceLogs::create($log);
    }

    public static function MultipleMinusPriceLogs($subject, $plus_price, $shop_id)
    {
        // return dd($subject->price);
        $log = [];
        $log['shop_id'] = $shop_id;

        $log['user_name'] = Auth::guard('shop_owners_and_staffs')->user()->name;

        $userRole = Auth::guard('shop_owners_and_staffs')->user()->role_id;
        switch ($userRole) {
            case 1:
                $log['user_role'] = 'admin';
                break;
            case 2:
                $log['user_role'] = 'manager';
                break;
            case 3:
                $log['user_role'] = 'staff';
                break;
            case 4:
                $log['user_role'] = 'shopowner';
                break;
            default:
                $log['user_role'] = 'unknown';
                break;
        }

        $log['item_id'] = $subject->id;
        $log['name'] = $subject->name;
        $log['product_code'] = $subject->product_code;
        if ($subject->min_price > 0) {
            $log['old_price'] = "-----";
            $log['new_price'] = "-----";
        } else {
            $log['old_price'] = $subject->price;
            $log['new_price'] = $subject->price - $plus_price;
        }

        if ($log['old_price'] > 0) {
            $log['min_price'] = "-----";
            $log['max_price'] = "-----";
            $log['new_min_price'] = "-----";
            $log['new_max_price'] = "-----";
        } else {
            $log['min_price'] = $subject->min_price;
            $log['max_price'] = $subject->max_price;
            $log['new_min_price'] = $subject->min_price - $plus_price;
            $log['new_max_price'] = $subject->max_price - $plus_price;
        }

        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;

        MultiplePriceLogs::create($log);

    }

    public static function logActivityLists()
    {
        return LogActivity::latest()->get();
    }

}
