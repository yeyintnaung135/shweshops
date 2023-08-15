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
use Yajra\DataTables\DataTables;

class SuperAdminRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    function list() {
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
        if ($request->ajax()) {
            $data = SuperAdmin::select(['id', 'name', 'email', 'role', 'created_at']);

            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->has('search.value')) {
                        $searchValue = $request->input('search.value');
                        $query->where('name', 'like', '%' . $searchValue . '%')
                            ->orWhere('email', 'like', '%' . $searchValue . '%')
                            ->orWhere('role', 'like', '%' . $searchValue . '%');
                    }
                })
                ->addColumn('action', function ($record) {
                    // Add any additional columns or actions you need here
                    return '<a href="#">Edit</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function get_admin_activity(Request $request)
    {
        if ($request->ajax()) {
            $data = SuperAdminLogActivity::query();

            $data->where(function ($query) use ($request) {
                $searchValue = $request->input('search.value');
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('type', 'like', '%' . $searchValue . '%')
                    ->orWhere('type_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('type_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('role', 'like', '%' . $searchValue . '%')
                    ->orWhere('status', 'like', '%' . $searchValue . '%');
            });

            $searchByFromdate = $request->input('searchByFromdate', '0-0-0 00:00:00');
            $searchByTodate = $request->input('searchByTodate', Carbon::now());

            $data->whereBetween('created_at', [$searchByFromdate, $searchByTodate]);

            return DataTables::of($data)
                ->addColumn('created_at_formatted', function ($record) {
                    return date('F d, Y ( h:i A )', strtotime($record->created_at));
                })
                ->make(true);
        }
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
