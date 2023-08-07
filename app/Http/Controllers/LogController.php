<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\frontuserlogs;
use App\Models\Guestoruserid;
use App\Http\Controllers\traid\logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class LogController extends Controller
{
    use logs;
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
        \LogActivity::addToLog('My Testing Add To Log.');
        \LogActivity::itemaddToLog('My Testing Add To Log.');

    }




    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function logActivity()
    {
        $logs = \LogActivity::logActivityLists();
        return view('logActivity',compact('logs'));
    }










    public function storeadsclicklog($name,$id){
          $this->addlog(url()->current(),'all','all','adsclick',$id);
          return redirect(url('/'.$name));



    }
}
