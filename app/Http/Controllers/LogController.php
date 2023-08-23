<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\Logs\LogActivityTrait;

class LogController extends Controller
{
    use LogActivityTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function myTestAddToLog()
    {
        $this->addToLog('My Testing Add To Log.');
        $this->itemaddToLog('My Testing Add To Log.');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function logActivity()
    {
        $logs = $this->logActivityLists();
        return view('logActivity', compact('logs'));
    }

    public function storeadsclicklog($name, $id)
    {
        $this->addlog(url()->current(), 'all', 'all', 'adsclick', $id);
        return redirect(url('/' . $name));

    }
}
