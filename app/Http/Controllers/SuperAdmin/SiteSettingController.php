<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\Request;

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
        $sitesettings = SiteSettings::All();
        return view('backend.super_admin.sitesetting.all', compact('sitesettings'));
    }

    public function update_action(Request $request)
    {
        SiteSettings::where('id', $request->id)->update(['action' => $request->action]);
        $action = SiteSettings::where('id', $request->id)->first()->action;
        return response()->json(['status' => 'success', 'action' => $action]);
    }

}
