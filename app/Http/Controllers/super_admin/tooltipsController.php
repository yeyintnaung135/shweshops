<?php

namespace App\Http\Controllers\super_admin;


use App\Http\Controllers\Controller;
use App\Superadmin;
use App\Tooltips;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class tooltipsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }

    public function createform()
    {
      return view('backend.super_admin.tooltips.create');
    }
    public function store(Request $request)
    {
        $val=Validator::make($request->all(),['endpoint'=>['string','required','max:222'],'info'=>['string','required','max:22222']]);
        if( $val->fails())
        {
            return redirect()->back()->withErrors($val)->withInput();
        }
        Tooltips::create($request->except('_token'));
        Session::flash('message', 'Your Tooltips was successfully Created');

        return redirect('backside/super_admin/tooltips/list');
    }
    public function detail($id)
    {
        $ttdata=Tooltips::where('id',$id)->first();
        return view('backend.super_admin.tooltips.detail',['ttdata'=>$ttdata]);

    }
    public function delete($id)
    {
        Tooltips::findOrFail($id)->delete();
       
        Session::flash('message', 'Your Tooltips was successfully deleted');

        return redirect('backside/super_admin/tooltips/list');

    }
    public function list(){
        $alltt=Tooltips::all();
        return view('backend.super_admin.tooltips.list',['alltt'=>$alltt]);
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
        if($columnName == 'url'){
            $columnName='endpoint';    
        }
        $totalRecords = Tooltips::select('count(*) as allcount')
            ->where('endpoint', 'like', '%' . $searchValue . '%')
            ->orWhere('info', 'like', '%' . $searchValue . '%')
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = Tooltips::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where('endpoint', 'like', '%' . $searchValue . '%')
            ->orWhere('info', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        $id = 1;
        foreach ($records as $record) {
            $data_arr[] = array(
                "id" =>$id++,
                "url" => $record->endpoint,
                "info" => $record->info,
                "action" => $record->id,
                "created_at" => $record->created_at
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

    public function edit($id)
    {
        $tooltip = Tooltips::findOrFail($id);
        return view('backend.super_admin.tooltips.edit',compact('tooltip'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'endpoint'=>['string','required','max:222'],
            'info'=>['string','required','max:22222']
        ]);
        $tooltip = Tooltips::findOrFail($id);

        $tooltip->endpoint = $request->endpoint;
        $tooltip->info = $request->info;
        $tooltip->update();
        Session::flash('message', 'Update Successfully');
        return redirect('backside/super_admin/tooltips/list');
    }
}
