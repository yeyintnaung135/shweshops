<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\LogActivity;
use Request;

trait LogActivityTrait
{

    public static function addToLog($subject)
    {

        $log = [];

        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        LogActivity::create($log);
    }

    public static function logActivityLists()
    {
        return LogActivity::latest()->get();
    }

}
