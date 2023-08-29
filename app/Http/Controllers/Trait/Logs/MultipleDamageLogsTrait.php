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

    public static function MultipleDamageLogsActivityLists()
    {
        return LogActivity::latest()->get();
    }

}
