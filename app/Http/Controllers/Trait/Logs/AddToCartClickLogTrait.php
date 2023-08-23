<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\AddToCartClickLog;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait AddToCartClickLogTrait
{

    public static function AddToCartClickLog($subject)
    {

        $log = [];
        if (isset(Auth::guard('web')->user()->id)) {
            $log['user_name'] = auth()->check() ? auth()->user()->username : 0;
        } else {
            $log['user_name'] = 'guest';
        }

        if (isset(Auth::guard('web')->user()->id)) {
            $log['user_id'] = auth()->check() ? auth()->user()->id : 0;
        } else {
            $log['user_id'] = Session::get('guest_id');
        }
        $log['shop_id'] = $subject->shop_id;
        AddToCartClickLog::create($log);
    }

    public static function logActivityLists()
    {
        return LogActivity::latest()->get();
    }

}
