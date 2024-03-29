<?php

namespace App\Helpers;

use App\Models\VisitorLogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VisitorLogActivityTrait
{

    public static function VisitorLogActivity($subject)
    {
        $log = [];
       

        $data = Session::all();

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

        VisitorLogActivity::create($log);
    }

}
