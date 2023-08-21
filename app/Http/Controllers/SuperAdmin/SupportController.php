<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CatSupport;
use App\Models\Support;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function create_form(): View
    {
        $cats = CatSupport::all();
        return view('backend.super_admin.support.create', ['cats' => $cats]);
    }

    function list(): View {
        return view('backend.super_admin.support.list');
    }

    public function get_all_support(): JsonResponse
    {
        $supportQuery = Support::select(
            'id', 'title', 'cat_id',
            'video', 'created_at',
        );

        return DataTables::of($supportQuery)
            ->editColumn('created_at', function ($support) {
                return date('F d, Y ( h:i A )', strtotime($support->created_at));
            })
            ->addColumn('category', function ($support) {
                return CatSupport::where('id', $support->cat_id)->first()->title;
            })
            ->addColumn('action', function ($support) {
                return $support->id;
            })
            ->make(true);
    }

    public function delete($id): RedirectResponse
    {
        Support::findOrFail($id)->delete();

        Session::flash('message', 'Your Support Video was successfully deleted');

        return redirect('backside/super_admin/support/list');

    }

    public function detail($id): View
    {
        $ttdata = Support::where('id', $id)->first();
        $ca = Catsupport::where('id', $ttdata->cat_id)->first()->title;

        return view('backend.super_admin.support.detail', [
            'ttdata' => $ttdata,
            'ca' => $ca,
        ]);

    }

    public function edit($id): View
    {
        $cats = CatSupport::all();

        $tooltip = Support::findOrFail($id);
        return view('backend.super_admin.support.edit', ['tooltip' => $tooltip, 'cats' => $cats]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => ['string', 'required', 'max:22222'],
            'video' => ['string', 'required', 'max:22222'],
        ]);
        $tooltip = Support::findOrFail($id);

        $tooltip->title = $request->title;
        $tooltip->video = $request->video;
        $tooltip->cat_id = $request->cat_id;
        $tooltip->for_what = $request->for_what;
        $tooltip->update();
        Session::flash('message', 'Update Successfully');
        return redirect('backside/super_admin/support/list');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:222'],
            'video' => ['required', 'string', 'max:22222'],
        ]);
        Support::create($request->except('_token'));
        Session::flash('message', 'Your Video was successfully Created');

        return redirect('backside/super_admin/support/list');
    }
}
