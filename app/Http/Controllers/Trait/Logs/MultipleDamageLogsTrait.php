<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\LogActivity;
use App\Models\MultipleDamageLogs;
use Illuminate\Support\Facades\Auth;

trait MultipleDamageLogsTrait
{
    public static function MultipleDamageLogs($subject, $old_percent, $shop_id)
    {

        // return dd($subject);
        $log = [];
        if (isset(Auth::guard('shop_owner')->user()->id)) {
            $log['shop_id'] = Auth::guard('shop_owner')->check() ? auth()->user()->id : 0;
        } elseif (isset(Auth::guard('shop_role')->user()->id)) {
            $log['shop_id'] = $shop_id;
        }
        $log['item_id'] = $subject->id;
        if (isset(Auth::guard('shop_role')->user()->id)) {
            $log['user_name'] = Auth::guard('shop_role')->user()->name;
        } else {
            $log['user_name'] = Auth::guard('shop_owner')->user()->name;
        }
        if (isset(Auth::guard('shop_owner')->user()->id)) {
            $log['user_role'] = 'shopowner';
        } elseif (isset(Auth::guard('shop_role')->user()->id)) {
            if (Auth::guard('shop_role')->user()->role_id == 1) {
                $log['user_role'] = 'admin';
            } elseif (Auth::guard('shop_role')->user()->role_id == 2) {
                $log['user_role'] = 'manager';
            } elseif (Auth::guard('shop_role')->user()->role_id == 3) {
                $log['user_role'] = 'staff';
            }
        }
        $log['name'] = $subject->name;
        $log['product_code'] = $subject->product_code;
        $log['new_decrease'] = $old_percent->အလျော့တွက်;
        $log['new_fee'] = $old_percent->လက်ခ;
        $log['new_undamage'] = $old_percent->undamaged_product;
        $log['new_damage'] = $old_percent->damaged_product;
        $log['new_expensive_thing'] = $old_percent->valuable_product;
        $log['decrease'] = $subject->handmade;
        $log['fee'] = $subject->charge;
        $log['undamage'] = $subject->undamaged_product;
        $log['damage'] = $subject->damaged_product;
        $log['expensive_thing'] = $subject->valuable_product;

        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        MultipleDamageLogs::create($log);
    }

    public static function logActivityLists()
    {
        return LogActivity::latest()->get();
    }

}
