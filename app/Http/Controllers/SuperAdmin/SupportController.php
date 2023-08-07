<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Catsupport;
use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SupportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }
    public function createform()
    {
        $cats = Catsupport::all();
        return view('backend.super_admin.support.create', ['cats' => $cats]);
    }
    function list() {
        return view('backend.super_admin.support.list');
    }
    public function all(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $totalRecords = Support::select('count(*) as allcount')
            ->where('title', 'like', '%' . $searchValue . '%')->orWhere('id', $searchValue)
            ->count();
        $totalRecordswithFilter = $totalRecords;
        if ($columnName == 'category') {
            $columnName = 'cat_id';
        }

        $records = Support::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where('title', 'like', '%' . $searchValue . '%')->orWhere('id', $searchValue)
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        $id = 1;
        foreach ($records as $record) {
            $cat = Catsupport::where('id', $record->cat_id)->first()->title;

            $data_arr[] = array(
                "id" => $record->id,
                "title" => Str::limit($record->title, 100, '...'),
                "video" => $record->video,
                "action" => $record->id,
                'category' => $cat,
                "created_at" => $record->created_at,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
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
        return view('backend.super_admin.support.detail', ['ttdata' => $ttdata]);

    }
    public function edit($id)
    {
        $cats = Catsupport::all();

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
        $val = Validator::make($request->all(), ['title' => ['string', 'required', 'max:222'], 'video' => ['string', 'required', 'max:22222']]);
        if ($val->fails()) {
            return redirect()->back()->withErrors($val)->withInput();
        }
        Support::create($request->except('_token'));
        Session::flash('message', 'Your Video was successfully Created');

        return redirect('backside/super_admin/support/list');
    }
}
