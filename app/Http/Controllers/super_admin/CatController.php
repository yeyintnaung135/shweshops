<?php

namespace App\Http\Controllers\super_admin;
use App\Catsupport;
use App\Http\Controllers\Controller;

use App\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CatController extends Controller
{
    //
    public function createform(){
        return view('backend.super_admin.support.category.create');
    }
    public function store(Request $request)
    {
        $val=Validator::make($request->all(),['title'=>['string','required','max:222']]);
        if( $val->fails())
        {
            return redirect()->back()->withErrors($val)->withInput();
        }
        Catsupport::create($request->except('_token'));
        Session::flash('message', 'Your Category was successfully Created');

        return redirect('backside/super_admin/support/cat/list');
    }
    public function list(){
        $catall=Catsupport::all();
        return view('backend.super_admin.support.category.list',['cats'=>$catall]);
    }
    public function delete(Request $request)
    {
        Catsupport::findOrFail($request->id)->delete();
        Support::where('cat_id',$request->id)->update(['cat_id'=>'1']);

        Session::flash('message', 'Your Category was successfully deleted');

        return redirect('backside/super_admin/support/cat/list');

    }
    public function edit($id)
    {
        $tooltip = Catsupport::findOrFail($id);
        return view('backend.super_admin.support.category.edit',compact('tooltip'));
    }
    public function update(Request $request,$id)
    {
        $request->validate([
            'title'=>['string','required','max:22222']
        ]);
        $tooltip = Catsupport::findOrFail($id);

        $tooltip->title = $request->title;
        $tooltip->update();
        Session::flash('message', 'Update Successfully');
        return redirect('backside/super_admin/support/cat/list');
    }
}
