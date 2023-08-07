<?php

namespace App\Http\Controllers\super_admin;

use App\sitesettings;
use App\Facade\Repair;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }
    public function index()
    {
      $sitesettings = sitesettings::All();
      return view('backend.super_admin.sitesetting.all', compact('sitesettings'));
    }

    public function updateAction(Request $request) {
      sitesettings::where('id',$request->id)->update(['action'=>$request->action]);
      $action = sitesettings::where('id', $request->id)->first()->action;
      return response()->json(['status'=>'success', 'action' => $action]);
    }

}
