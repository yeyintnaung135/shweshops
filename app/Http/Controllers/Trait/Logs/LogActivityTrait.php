<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\LogActivity;
use Illuminate\Support\Facades\Request;

trait LogActivityTrait
{

    public static function addToLog($subject)
    {
        $log = [];

        $log['subject'] = $subject;
        $log['url'] = request()->fullUrl();
        $log['method'] = request()->method();
        $log['ip'] = request()->ip();
        $log['agent'] = request()->header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;

        // Assuming you have a model named LogActivity with a create method
        LogActivity::create($log);
    }

    public static function logActivityLists()
    {
        return LogActivity::latest()->get();
    }

}
