<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CatSupport;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SupportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }
    public function create_form()
    {
        $cats = CatSupport::all();
        return view('backend.super_admin.support.create', ['cats' => $cats]);
    }
    public function list() {
        return view('backend.super_admin.support.list');
    }
    public function all(Request $request)
    {
        if ($request->ajax()) {
        $data = Support::query();

        $data->where('title', 'like', '%' . $request->input('search.value') . '%')
             ->orWhere('id', $request->input('search.value'));

        $totalRecords = $data->count();
        $totalRecordswithFilter = $totalRecords;

        if ($request->input('order.0.column') == '1') {
            $data->orderBy('cat_id', $request->input('order.0.dir'));
        } else {
            $data->orderBy($request->input('columns.' . $request->input('order.0.column') . '.data'), $request->input('order.0.dir'));
        }

        $records = $data->skip($request->input('start'))
                        ->take($request->input('length'))
                        ->get();

        $data_arr = [];
        foreach ($records as $record) {
            $cat = CatSupport::where('id', $record->cat_id)->first()->title;

            $data_arr[] = [
                "id" => $record->id,
                "title" => Str::limit($record->title, 100, '...'),
                "video" => $record->video,
                "action" => $record->id,
                'category' => $cat,
                "created_at" => $record->created_at,
            ];
        }

        return DataTables::of($data_arr)
            ->addColumn('action', function ($record) {
                return '<a href="#">Edit</a>'; // Add your action link here
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    }
    public function delete($id)
    {
        Support::findOrFail($id)->delete();

        Session::flash('message', 'Your Support Video was successfully deleted');

        return redirect('backside/super_admin/support/list');

    }
    public function detail($id)
    {

        $ttdata = Support::where('id', $id)->first();
        $ca = Catsupport::where('id', $ttdata->cat_id)->first()->title;

        return view('backend.super_admin.support.detail', [
            'ttdata' => $ttdata,
            'ca' => $ca,
        ]);

    }
    public function edit($id)
    {
        $cats = CatSupport::all();

        $tooltip = Support::findOrFail($id);
        return view('backend.super_admin.support.edit', ['tooltip' => $tooltip, 'cats' => $cats]);
    }
    public function update(Request $request, $id)
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
    public function store(Request $request)
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
