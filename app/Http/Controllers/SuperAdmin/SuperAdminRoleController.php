<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Facade\TzGate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\Logs\SuperAdminLogActivityTrait;
use App\Http\Requests\SuperAdmin\SuperAdminRole\UpdateSuperAdminRoleRequest;
use App\Models\SuperAdmin;
use App\Models\SuperAdminLogActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SuperAdminRoleController extends Controller
{
    use SuperAdminLogActivityTrait;
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    function list(): View {
        $super_admin = SuperAdmin::all();
        $super_admin_log = SuperAdminLogActivity::all();
        return view('backend.super_admin_role.list', ['super_admin' => $super_admin, 'super_admin_log' => $super_admin_log]);

    }
    public function activity_index(): View
    {
        $super_admin = SuperAdmin::all();
        $super_admin_log = SuperAdminLogActivity::all();
        return view('backend.super_admin.activity_logs.admin', ['super_admin' => $super_admin, 'super_admin_log' => $super_admin_log]);
    }
    public function get_all_admins(): JsonResponse
    {
        $data = SuperAdmin::select(['id', 'name', 'email', 'role', 'created_at']);

        return DataTables::of($data)
            ->addColumn('action', fn($record) => $record->id)
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->rawColumns(['action', 'created_at'])
            ->make(true);
    }

    public function get_admin_activity(Request $request): JsonResponse
    {

        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $data = SuperAdminLogActivity::select(
            'id', 'name', 'type',
            'type_name', 'status', 'role', 'created_at',
        )->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($data)
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->make(true);
    }

    public function create(): View
    {
        return view('backend.super_admin_role.create');
    }

    public function store(Request $request): RedirectResponse
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

            $this->SuperAdminAdminCreateLog($validatedData);
        }

        return redirect()->route('super_admin_role.list')->with(['status' => 'success', 'message' => 'Sub Admin was successfully created']);

    }

    public function edit($id): View
    {

        if (TzGate::super_admin_allows($id)) {
            $super_admin = SuperAdmin::findOrFail($id);
            return view('backend.super_admin_role.edit', ['super_admin' => $super_admin]);
        }

    }

    public function update(UpdateSuperAdminRoleRequest $request, $id): RedirectResponse
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

        $this->SuperAdminAdminEditLog($request->except('_token', '_method'));
        Session::flash('message', 'Your admin was successfully updated');

        return redirect('/backside/super_admin/admins/all');
    }

}
