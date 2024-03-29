<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\FilterLogActivity;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Request;

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
        return LogActivity::latest()->get();
    }

}
