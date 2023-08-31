<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\LogActivity;
use App\Models\MultipleDiscountLogs;
use Illuminate\Support\Facades\Auth;

trait MultipleDiscountLogsTrait
{

    public static function MultipleDiscountLogs($p, $discount, $olddiscount, $shop_id)
    {

        $log = [];
        $log['shop_id'] = $shop_id;
        $log['item_id'] = $p->id;
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

        $log['name'] = $p->name;
        $log['product_code'] = $p->product_code;
        if ($p->min_price > 0) {
            $log['old_price'] = "-----";
        } else {
            $log['old_price'] = $p->price;
        }

        if ($p->price > 0) {
            $log['old_min_price'] = "-----";
            $log['old_max_price'] = "-----";
        } else {
            $log['old_min_price'] = $p->min_price;
            $log['old_max_price'] = $p->max_price;
        }
        $log['percent'] = $discount->percent;
        foreach ($olddiscount as $olddiscount) {

            if ($p->min_price > 0) {
                $log['old_discount_price'] = "-----";
            } elseif ($discount->discount_price === 0) {
                $log['old_discount_price'] = "-----";
            } else {
                $log['old_discount_price'] = $olddiscount->discount_price;
            }

            if ($p->price > 0) {
                $log['old_discount_min'] = "-----";
                $log['old_discount_max'] = "-----";
            } elseif ($discount->discount_min === 0) {
                $log['old_discount_min'] = "-----";
                $log['old_discount_max'] = "-----";
            } else {
                $log['old_discount_min'] = $olddiscount->discount_min;
                $log['old_discount_max'] = $olddiscount->discount_max;
            }

        }

        if ($p->min_price > 0) {
            $log['new_discount_price'] = "-----";
        } elseif ($discount->discount_price === 0) {
            $log['new_discount_price'] = "-----";
        } else {
            $log['new_discount_price'] = $discount->discount_price;
        }

        if ($p->price > 0) {
            $log['new_discount_min'] = "-----";
            $log['new_discount_max'] = "-----";
        } elseif ($discount->discount_min === 0) {
            $log['new_discount_min'] = "-----";
            $log['new_discount_max'] = "-----";
        } else {
            $log['new_discount_min'] = $discount->discount_min;
            $log['new_discount_max'] = $discount->discount_max;
        }

        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        MultipleDiscountLogs::create($log);
    }

    public static function MultipleNoneDiscountLogs($p, $discount, $olddiscount, $shop_id)
    {

        $log = [];

        $log['shop_id'] = $shop_id;
        $log['item_id'] = $p->id;
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

        $log['name'] = $p->name;
        $log['product_code'] = $p->product_code;
        if ($p->min_price > 0) {
            $log['old_price'] = "-----";
        } else {
            $log['old_price'] = $p->price;
        }

        if ($p->price > 0) {
            $log['old_min_price'] = "-----";
            $log['old_max_price'] = "-----";
        } else {
            $log['old_min_price'] = $p->min_price;
            $log['old_max_price'] = $p->max_price;
        }

        $log['percent'] = $discount->percent;
        foreach ($olddiscount as $olddiscount) {
            if ($p->min_price > 0) {
                $log['old_discount_price'] = "-----";
            } elseif ($discount->discount_price === 0) {
                $log['old_discount_price'] = "-----";
            } else {
                $log['old_discount_price'] = $olddiscount->discount_price;
            }

            if ($p->price > 0) {
                $log['old_discount_min'] = "-----";
                $log['old_discount_max'] = "-----";
            } elseif ($discount->discount_min === 0) {
                $log['old_discount_min'] = "-----";
                $log['old_discount_max'] = "-----";
            } else {
                $log['old_discount_min'] = $olddiscount->discount_min;
                $log['old_discount_max'] = $olddiscount->discount_max;
            }
        }

        if ($p->min_price > 0) {
            $log['new_discount_price'] = "-----";
        } else {
            $log['new_discount_price'] = $discount->discount_price;
        }

        if ($p->price > 0) {
            $log['new_discount_min'] = "-----";
            $log['new_discount_max'] = "-----";
        } elseif ($discount->discount_min === 0) {
            $log['new_discount_min'] = "-----";
            $log['new_discount_max'] = "-----";
        } else {
            $log['new_discount_min'] = $discount->discount_min;
            $log['new_discount_max'] = $discount->discount_max;
        }

        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        MultipleDiscountLogs::create($log);
    }

    public static function logActivityLists()
    {
        return LogActivity::latest()->get();
    }

}
