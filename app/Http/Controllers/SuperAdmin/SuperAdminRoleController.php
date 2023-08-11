<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Facade\TzGate;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\SuperAdminRole\UpdateSuperAdminRoleRequest;
use App\Models\SuperAdmin;
use App\Models\SuperAdminLogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SuperAdminRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function list() {
        $super_admin = SuperAdmin::all();
        $super_admin_log = SuperAdminLogActivity::all();
        return view('backend.super_admin_role.list', ['super_admin' => $super_admin, 'super_admin_log' => $super_admin_log]);

    }
    public function activity_index()
    {
        $super_admin = SuperAdmin::all();
        $super_admin_log = SuperAdminLogActivity::all();
        return view('backend.super_admin.activity_logs.admin', ['super_admin' => $super_admin, 'super_admin_log' => $super_admin_log]);

    }
    public function get_all_admins(Request $request)
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

        $totalRecords = SuperAdmin::select('count(*) as allcount')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('email', 'like', '%' . $searchValue . '%')
            ->orWhere('role', 'like', '%' . $searchValue . '%')
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = SuperAdmin::orderBy($columnName, $columnSortOrder)
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

    public function get_admin_activity(Request $request)
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

        $totalRecords = SuperAdminLogActivity::select('count(*) as allcount')
            ->where(function ($query) use ($searchValue) {
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
        $records = SuperAdminLogActivity::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
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

    public function create()
    {
        return view('backend.super_admin_role.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:super_admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $super_admin_data = SuperAdmin::create([
            'name' => $validatedData['name'],
            'role' => "1",
            // 'role' => '0',
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'active' => 'yes',
        ]);

        if ($super_admin_data) {

            \SuperAdminLogActivity::SuperAdminAdminCreateLog($validatedData);
        }

        return redirect()->route('super_admin_role.list')->with(['status' => 'success', 'message' => 'Sub Admin was successfully created']);

    }

    public function edit($id)
    {

        if (TzGate::super_admin_allows($id)) {
            $super_admin = SuperAdmin::findOrFail($id);
            return view('backend.super_admin_role.edit', ['super_admin' => $super_admin]);
        }

    }

    public function update(UpdateSuperAdminRoleRequest $request, $id)
    {
        if (!TzGate::super_admin_allows($id)) {
            abort(403, 'You are not authorized to perform this action.');
        }

        $admin = SuperAdmin::findOrFail($id);

        if ($request->filled(['current_password', 'new_password', 'new_confirm_password'])) {
            $admin->password = Hash::make($request->new_password);
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        \SuperAdminLogActivity::SuperAdminAdminEditLog($request->except('_token', '_method'));
        Session::flash('message', 'Your admin was successfully updated');

        return redirect('/backside/super_admin/admins/all');
    }

}
