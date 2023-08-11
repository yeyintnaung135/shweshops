<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Directory\StoreDirectoryRequest;
use App\Http\Requests\SuperAdmin\Directory\UpdateDirectoryRequest;
use App\Models\ShopDirectory;
use App\Models\State;
use App\Models\Tooltips;
use App\Models\Township;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class DirectoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function all_table()
    {
        return view('backend.super_admin.directory.list');
    }

    public function all_directory(Request $request)
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

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');

        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }

        $totalRecords = ShopDirectory::select('count(*) as allcount')
            ->where('shop_name', '!=', '')
            ->where(function ($query) use ($searchValue) {
                $query->orWhere('shop_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('main_phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('address', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;

        $records = ShopDirectory::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where('shop_id', '=', '0')
            ->where(function ($query) use ($searchValue) {
                $query->orWhere('shop_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('main_phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('address', 'like', '%' . $searchValue . '%');
            })

            ->select('shop_directory.*')
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "shop_name" => $record->shop_name,

                "shop_logo" => $record->shop_logo,

                "main_phone" => $record->main_phone,
                "action" => $record->id,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->created_at)),
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

    public function get_township(Request $request)
    {
        if (is_array($request->id)) {
            $townships = Township::select('id', 'name', 'myan_name')->whereIn('state_id', $request->id)->get();
        } else {
            $townships = Township::select('id', 'name', 'myan_name')->where('state_id', $request->id)->get();
        }
        return response()->json($townships);
    }

    public function check_shop_directory_name(Request $request)
    {
        if (ShopDirectory::where('shop_name', '=', $request->shopName)->exists()) {
            $isExit = true;
        } else {
            $isExit = false;
        }
        return response()->json([
            'isExit' => $isExit,
        ]);
    }

    public function create_form()
    {
        $states = State::get();
        return view('backend.super_admin.directory.create', ['states' => $states]);
    }

    public function store(StoreDirectoryRequest $request)
    {
        // dd($request);
        $data = $request->validated();
        if ($request->hasFile('shop_logo')) {
            $shop_logo = $data['shop_logo'];

            //file upload
            $imageNameone = time() . 'logo' . '.' . $shop_logo->getClientOriginalExtension();

            $lpath = $shop_logo->move(public_path('images/directory/'), $imageNameone);
            $data['shop_logo'] = $imageNameone;
        }
        $add_ph = json_decode($request->additional_phones);
        $add_ph_array = [];

        if (json_decode($request->additional_phones) !== null) {
            foreach ($add_ph as $k => $v) {
                if (count($add_ph) != 0) {
                    $ph = json_decode(json_encode($v), true);
                    foreach ($ph as $k2 => $v2) {
                        array_push($add_ph_array, $v2);
                    }
                }
            }
        }
        // $state = json_decode($request->state);
        // $state_array = [];
        // if(json_decode($request->state)!== null){
        //   foreach($state as $k=>$v){
        //     if(count($state) != 0){
        //       $st = json_decode(json_encode($v), true);
        //       foreach ($st as $k2=>$v2) {
        //         array_push($state_array,$v2);
        //       }
        //     }
        //   }
        // }

        $data['additional_phones'] = json_encode($add_ph_array);
        ShopDirectory::create($data);
        Session::flash('message', 'Your Shop Directory was successfully Created');

        return redirect('backside/super_admin/directory/all');
    }
    public function detail($id)
    {
        $ttdata = ShopDirectory::where('id', $id)->first();
        return view('backend.super_admin.directory.detail', ['ttdata' => $ttdata]);

    }
    public function edit_form($id)
    {
        $states = State::get();
        $ttdata = ShopDirectory::where('id', $id)->first();
        return view('backend.super_admin.directory.edit', ['ttdata' => $ttdata, 'states' => $states]);

    }
    public function update(UpdateDirectoryRequest $request)
    {
        $sd = ShopDirectory::where('id', $request->id)->first();
        $data = $request->validated();

        if ($request->file('shop_logo')) {

            if (File::exists(public_path('image/directory/' . $sd->shop_logo))) {
                File::delete(public_path('image/directory/' . $sd->shop_logo));
            }

            $shop_logo = time() . '1.' . $request->file('shop_logo')->getClientOriginalExtension();
            $get_path = $request->file('shop_logo')->move(public_path('images/directory'), $shop_logo);

            $data['shop_logo'] = $shop_logo;

        }
        $add_ph = json_decode($request->additional_phones);
        $add_ph_array = [];

        if (json_decode($request->additional_phones) !== null) {
            foreach ($add_ph as $k => $v) {
                if (count($add_ph) != 0) {
                    $ph = json_decode(json_encode($v), true);
                    foreach ($ph as $k2 => $v2) {
                        array_push($add_ph_array, $v2);
                    }
                }
            }
        }
        $data['additional_phones'] = json_encode($add_ph_array);
        ShopDirectory::where('id', $request->id)->update($data);

        Session::flash('message', 'Your Shop Directory was successfully Edited');

        return redirect('backside/super_admin/directory/all');

    }
    public function delete(Request $request)
    {
        $sd = ShopDirectory::where('id', $request->id)->first();

        if (File::exists(public_path('image/directory/' . $sd->shop_logo))) {
            File::delete(public_path('image/directory/' . $sd->shop_logo));
        }

        ShopDirectory::where('id', $request->id)->delete();
        Session::flash('message', 'Your Tooltips was successfully deleted');

        return redirect('backside/super_admin/directory/all');

    }
    public function list() {
        $alltt = Tooltips::all();
        return view('backend.super_admin.tooltips.list', ['alltt' => $alltt]);
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

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "url" => $record->name,
                "info" => $record->email,
                "id" => $record->id,
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
}
