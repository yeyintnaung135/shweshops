<?php

namespace App\Http\Controllers\super_admin;

use App\Superadmin;
use App\Facade\TzGate;
use App\Super_admin_role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\SuperadminLogActivity;
use App\Rules\MatchOldPassword;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Super_admin_roleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin','admin']);
    }

    public function list(){
        $super_admin = Superadmin::all();
        $super_admin_log = SuperadminLogActivity::all();
        return view('backend.super_admin_role.list',['super_admin'=>$super_admin,'super_admin_log'=>$super_admin_log]);

    }
    public function activity_index(){
        $super_admin = Superadmin::all();
        $super_admin_log = SuperadminLogActivity::all();
        return view('backend.super_admin.activity_logs.admin',['super_admin'=>$super_admin,'super_admin_log'=>$super_admin_log]);

    }
    public function getAllAdmins(Request $request) {
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

      $totalRecords = Superadmin::select('count(*) as allcount')
                      ->where('name', 'like', '%' . $searchValue . '%')
                      ->orWhere('email', 'like', '%' . $searchValue . '%')
                      ->orWhere('role', 'like', '%' . $searchValue . '%')
                      ->count();
      $totalRecordswithFilter = $totalRecords;

      $records = Superadmin::orderBy($columnName, $columnSortOrder)
          ->orderBy('created_at', 'desc')
          ->where('name', 'like', '%' . $searchValue . '%')
          ->orWhere('email', 'like', '%' . $searchValue . '%')
          ->orWhere('role', 'like', '%' . $searchValue . '%')
          ->select('super_admins.*')
          ->skip($start)
          ->take($rowperpage)
          ->get();

      $data_arr = array();

      foreach ($records as $record) {
        $data_arr[] = array(
            "id" => $record->id,
            "name" => $record->name,
            "email" => $record->email,
            "role" => $record->role,
            "id" => $record->id,
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

    public function getAdminActivity(Request $request) {
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
        
      if($searchByFromdate == null) {
        $searchByFromdate = '0-0-0 00:00:00';
      }
      if($searchByTodate == null) {
        $searchByTodate = Carbon::now();
      }

      $totalRecords = SuperadminLogActivity::select('count(*) as allcount')
                      ->where(function ($query) use($searchValue) {
                        $query->where('name', 'like', '%' . $searchValue . '%')
                              ->orWhere('type', 'like', '%' . $searchValue . '%')
                              ->orWhere('type_id', 'like', '%' . $searchValue . '%')
                              ->orWhere('type_name', 'like', '%' . $searchValue . '%')
                              ->orWhere('role', 'like', '%' . $searchValue . '%')
                              ->orWhere('status', 'like', '%' . $searchValue . '%');
                      })
                      ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
                      ->count();
      $totalRecordswithFilter = $totalRecords;
      //   $admin = where('type',['admin'])->orWhere('type',['sub-admin'])->orderBy('created_at', 'desc')->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->get();
      $records = SuperadminLogActivity::orderBy($columnName, $columnSortOrder)
          ->orderBy('created_at', 'desc')
          ->where(function ($query) use($searchValue) {
              $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('type', 'like', '%' . $searchValue . '%')
                    ->orWhere('type_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('type_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('role', 'like', '%' . $searchValue . '%')
                    ->orWhere('status', 'like', '%' . $searchValue . '%');
            })
          ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
          ->select('superadmin_log_activities.*')
          ->skip($start)
          ->take($rowperpage)
          ->get();

      $data_arr = array();

      foreach ($records as $record) {
        $data_arr[] = array(
            "id" => $record->id,
            "name" => $record->name,
            "type" => $record->type,
            "type_name" => $record->type_name,
            "status" => $record->status,
            "role" => $record->role,
            "created_at" => date('F d, Y ( h:i A )',strtotime($record->created_at)),
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

    public function create(){
        return view('backend.super_admin_role.create');
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:super_admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function store(Request $request){
        
        $valid=$this->validator($request->except('_token'));
        if( $valid->fails())
        {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->except("_token");
        $super_admin_data = Superadmin::create([
            'name' => $data['name'],
            'role' => "1",
            // 'role' => '0',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => 'yes'
        ]);

        if($super_admin_data){
         
            \SuperadminLogActivity::SuperadminAdminCreateLog($data);
        }

        return redirect()->route('super_admin_role.list')->with(['status' => 'success', 'message' => 'Sub Admin was successfully created']);

    }

    public function edit($id){
       
        if(TzGate::super_admin_allows($id)){
            $super_admin = Superadmin::findOrFail($id);
            return view('backend.super_admin_role.edit',['super_admin'=>$super_admin]);
        }
        
    }

    public function update(Request $request,$id){
        if(TzGate::super_admin_allows($id)){
            $admin = Superadmin::findOrFail($id);
        }
      
        if($request->current_password || $request->new_password || $request->new_confirm_password){
        
            $request->validate([
                'current_password' => ['required','min:8', new MatchOldPassword],

                'new_password' => ['required','min:8'],
    
                'new_confirm_password' => ['same:new_password'],
            ]);
            $admin->password = Hash::make($request->new_password);
        }else{
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
            ]);
        }
      
        $input = $request->except('_token', '_method');
      
        $admin->name = $request->name;
        $admin->email = $request->email;
        $result = $admin->update();

        if($result){
            \SuperadminLogActivity::SuperadminAdminEditLog($input);
             Session::flash('message', 'Your admin was successfully updated');
            return redirect('/backside/super_admin/admins/all');
        }
        

    }

}
