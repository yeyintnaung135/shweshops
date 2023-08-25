<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\FilterLogActivity;
use Illuminate\Support\Facades\Auth;
use Request;

trait FilterLogActivityTrait
{

    public static function FilteraddToLog($price)
    {

        $log = [];

        $log['price'] = $price;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        FilterLogActivity::create($log);
    }

    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }

}
