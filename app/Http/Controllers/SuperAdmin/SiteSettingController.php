<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }
    public function index(): View
    {
        $sitesettings = SiteSettings::All();
        return view('backend.super_admin.sitesetting.all', compact('sitesettings'));
    }

    public function update_action(Request $request): JsonResponse
    {
        SiteSettings::where('id', $request->id)->update(['action' => $request->action]);
        $action = SiteSettings::where('id', $request->id)->first()->action;
        return response()->json(['status' => 'success', 'action' => $action]);
    }

}
