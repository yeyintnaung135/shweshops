<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CatSupport;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CatController extends Controller
{
    //
    public function create_form()
    {
        return view('backend.super_admin.support.category.create');
    }

    public function store(Request $request)
    {
        $val = Validator::make($request->all(), ['title' => ['string', 'required', 'max:222']]);
        if ($val->fails()) {
            return redirect()->back()->withErrors($val)->withInput();
        }
        CatSupport::create($request->except('_token'));
        Session::flash('message', 'Your Category was successfully Created');

        return redirect('backside/super_admin/support/cat/list');
    }
    public function list() {
        $catall = CatSupport::all();
        return view('backend.super_admin.support.category.list', ['cats' => $catall]);
    }

    public function delete(Request $request)
    {
        CatSupport::findOrFail($request->id)->delete();
        Support::where('cat_id', $request->id)->update(['cat_id' => '1']);

        Session::flash('message', 'Your Category was successfully deleted');

        return redirect('backside/super_admin/support/cat/list');

    }

    public function edit($id)
    {
        $tooltip = CatSupport::findOrFail($id);
        return view('backend.super_admin.support.category.edit', compact('tooltip'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['string', 'required', 'max:22222'],
        ]);
        $tooltip = CatSupport::findOrFail($id);

        $tooltip->title = $request->title;
        $tooltip->update();
        Session::flash('message', 'Update Successfully');
        return redirect('backside/super_admin/support/cat/list');
    }
}
