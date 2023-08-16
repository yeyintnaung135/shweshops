<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\UserRole;
use App\Models\BackroleEditDetail;
use App\Models\BackroleLogActivity;
use App\Models\ItemLogActivity;
use App\Models\ItemsEditDetailLogs;
use App\Models\Role;
use App\Models\ShopownerLogActivity;
use App\Models\ShopOwnersAndStaffs;
use App\Models\Shops;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{
    use UserRole;

    public function __construct()
    {
        $this->middleware('auth:shop_owners_and_staffs');
    }

    public function list() {
        Gate::authorize('to_create_user', 3);
        $itemlogs = ItemLogActivity::all();
        $backrolelogs = BackroleLogActivity::all();

        $shopdata = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        return view('backend.shopowner.manager.list', ['shopowner' => $shopdata, 'itemlogs' => $itemlogs, 'manager' => $this->getuserlistbyrolelevel()]);
    }
    public function u_product()
    {
        Gate::authorize('to_create_user', 3);

        $itemlogs = ItemLogActivity::all();
        $backrolelogs = BackroleLogActivity::all();
        // return dd($backrolelogs);

        $shopdata = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        return view('backend.shopowner.activity.user.product', ['shopowner' => $shopdata, 'itemlogs' => $itemlogs, 'manager' => $this->getuserlistbyrolelevel()]);
    }
    public function u_role()
    {
        Gate::authorize('to_create_user', 3);

        $itemlogs = ItemLogActivity::all();
        $backrolelogs = BackroleLogActivity::all();
        // return dd($backrolelogs);

        $shopdata = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        return view('backend.shopowner.activity.user.role', ['shopowner' => $shopdata, 'itemlogs' => $itemlogs, 'manager' => $this->getuserlistbyrolelevel()]);
    }
    public function get_users_activity_log(Request $request)
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('toDate') ?? Carbon::now();

        $recordsQuery = ShopownerLogActivity::select('shopowner_log_activities.*')
            ->where('shop_id', $shop_id)
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->orderBy('created_at', 'desc');

        return DataTables::of($recordsQuery)
            ->addColumn('created_at_formatted', function ($record) {
                return $record->created_at->format('d-m-Y H:i:s');
            })
            ->addColumn('btn', function ($record) {
                return $record->id;
            })
            ->rawColumns(['created_at_formatted', 'action', 'btn'])
            ->make(true);

    }

    // datable for backrole log activity
    public function get_back_role_activity(Request $request)
    {
        $shop_id = $this->get_shopid();

    $query = BackroleLogActivity::query()
        ->where('shop_id', $shop_id)
        ->whereBetween('created_at', [
            $request->input('searchByFromdate', '0-0-0 00:00:00'),
            $request->input('searchByTodate', Carbon::now())
        ]);

    return DataTables::of($query)
    ->addColumn('created_at_formatted', function ($record) {
        return $record->created_at->format('d-m-Y H:i:s');
    })
    ->addColumn('btn', function ($record) {
        return $record->id;
    })
    ->rawColumns(['created_at_formatted', 'action', 'btn'])
    ->make(true);

    }

    public function get_back_role_activity_detail(Request $request)
    {

        $detail = BackroleEditdetail::where("backrole_log_activities_id", $request->id)->first();
        echo json_encode($detail);
    }

    // for datatable
    public function get_item_edit_activity_detail(Request $request)
    {

        $detail = ItemsEditDetailLogs::where("shopownereditlogs_id", $request->id)->first();
        echo json_encode($detail);
    }

    public function back_role_edit_detail($id)
    {
        $detail_id = BackroleEditdetail::findOrFail($id)->user_id;
        return view('backend.shopowner.manager.editdetail', ['detail_id' => $detail_id]);
    }

    public function get_users(Request $request)
    {

        if (Auth::guard('shop_role')->check()) {
            $query = ShopOwnersAndStaffs::query()
                ->orderBy($request->input('columns')[0]['data'], $request->input('order')[0]['dir'])
                ->where('shop_id', Auth::user()->role_id)
                ->whereIn('role_id', [3])
                ->where(function ($query) use ($request) {
                    $searchValue = $request->input('search.value', '');
                    $query->where('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('phone', 'like', '%' . $searchValue . '%');
                });
        } else {
            $this->role('shop_owner');
            $query = ShopOwnersAndStaffs::query()
                ->orderBy($request->input('columns')[0]['data'], $request->input('order')[0]['dir'])
                ->where('shop_id', $this->role)
                ->where(function ($query) use ($request) {
                    $searchValue = $request->input('search.value', '');
                    $query->where('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('phone', 'like', '%' . $searchValue . '%');
                });
        }

        return DataTables::of($query)
            ->addColumn('action', function ($user) {
                return $user->id;
            })
            ->addColumn('role_name', function ($user) {
                return $user->role->name;
            })
            ->addColumn('created_at_formatted', function ($user) {
                return $user->created_at->format('Y-m-d H:i:s');
            })
            ->make(true);
    }

    public function create()
    {
        $this->authorize('to_create_user', 3);

        //tz
        if ($this->is_admin() or $this->is_manager()) {

            if ($this->is_admin()) {
                $role_limit = [2, 3];
            } else if ($this->is_manager()) {

                $role_limit = [3];
            } else {
                $role_limit = [1, 2, 3];
            }
        }
        $role = Role::whereIn('id', $role_limit)->orderBy('created_at', 'desc')->get();

        return view('backend.shopowner.manager.create', ['shopowner' => $this->get_currentauthdata(), 'role' => $role]);
    }

    public function store(Request $request)
    {

        $input = $request->except('_token');
        $this->authorize('to_create_user', $input['role_id']);

        $rules = [

            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:11'],
            'password' => ['required', 'string', 'max:255'],
            //rules
            'phone' => 'unique:shop_owners_and_staffs,phone|unique:shops,main_phone',

        ];
        $shop_id = $this->get_shopid();

        // \BackroleLogActivity::BackroleCreateLog($input,$shop_id);

        $input['password'] = Hash::make($input['password']);
        $input['shop_id'] = $shop_id;
        $validate = Validator::make($input, $rules);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        } elseif (ShopOwnersAndStaffs::create($input)) {
            if ($input['role_id'] == 1) {
                Session::flash('message', 'Your admin was successfully added');
            } else if ($input['role_id'] == 2) {
                Session::flash('message', 'Your manager was successfully added');
            } else if ($input['role_id'] == 3) {
                Session::flash('message', 'Your staff was successfully added');
            }
            return redirect('/backside/shop_owner/users');
        }
    }

    public function detail($id)
    {
        $staffdata = ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->where('id', $id)->first();
        $role_id = $staffdata->role_id;

        $this->authorize('to_create_user', $role_id);
        $role = Role::all();
        $url_id = $this->get_shopid();

        return view('backend.shopowner.manager.detail', ['shopowner' => $this->current_shop_data(), 'role' => $role, 'manager' => $staffdata]);
    }

    public function edit($id)
    {
        $role = $this->get_role_list();
        $shop_id = $this->get_shopid();
        $staffdata = ShopOwnersAndStaffs::where('shop_id', $shop_id)->where('id', $id)->first();

        $this->authorize('to_create_user', $staffdata->role_id);

        return view('backend.shopowner.manager.edit', ['shopowner' => $this->current_shop_data(), 'role' => $role, 'manager' => $staffdata]);
    }

    public function update(Request $request, $id)
    {
        $shop_id = $this->get_shopid();

        //remove token and method from request
        $input = $request->except('_token', '_method');

        $manager = ShopOwnersAndStaffs::where('shop_id', $shop_id)->where('id', $id)->first();
        $this->authorize('to_create_user', $input['role_id']);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:11'],
            'role_id' => ['required', 'max:255', Rule::in('1', '2', '3')],

            //rules
            'phone' => [
                'required',
                Rule::unique('shop_owners_and_staffs')->ignore($manager->id),
            ],

        ];
        $validate = Validator::make($input, $rules);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        } else {

            if (ShopOwnersAndStaffs::where('id', $id)->update($input)) {
                // $backroleid = BackroleLogActivity::BackroleEditLog($input, $shop_id);

                // $old_name = $manager->name;
                // $old_phone = $manager->phone;
                // $old_role = Role::where('id', $manager->role_id)->first();
                // $old_role_id = $old_role->name;
                // // return dd($old_role_id);

                // $new_name = $request['name'];
                // $new_phone = $request['phone'];
                // $new = $request['role_id'];
                // $new_role = Role::where('id', $new)->first();
                // $new_role_id = $new_role->name;
                // // return dd($new_role_id);

                // if ($old_name == $new_name && $old_phone == $new_phone && $old_role_id == $new_role_id) {
                //     // return dd($old_name,$new_name,$old_phone,$new_phone,$old_role_id,$new_role_id);
                //     $back_role_edit_detail = new BackroleEditdetail();
                //     $back_role_edit_detail->old_name = "no";
                //     $back_role_edit_detail->new_name = "no";
                //     $back_role_edit_detail->old_phone = "no";
                //     $back_role_edit_detail->new_phone = "no";
                //     $back_role_edit_detail->old_role_id = "no";
                //     $back_role_edit_detail->new_role_id = "no";
                //     $back_role_edit_detail->user_id = $id;
                //     $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                //     $back_role_edit_detail->save();
                //     if ($input['role_id'] == 1) {
                //         Session::flash('message', 'Your admin was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 2) {
                //         Session::flash('message', 'Your manager was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 3) {
                //         Session::flash('message', 'Your staff was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     }
                // } else if ($old_name !== $new_name && $old_phone !== $new_phone && $old_role_id !== $new_role_id) {
                //     // return dd($old_name,$new_name,$old_phone,$new_phone,$old_role_id,$new_role_id);
                //     $back_role_edit_detail = new BackroleEditdetail();
                //     $back_role_edit_detail->old_name = $old_name;
                //     $back_role_edit_detail->new_name = $new_name;
                //     $back_role_edit_detail->old_phone = $old_phone;
                //     $back_role_edit_detail->new_phone = $new_phone;
                //     $back_role_edit_detail->old_role_id = $old_role_id;
                //     $back_role_edit_detail->new_role_id = $new_role_id;
                //     $back_role_edit_detail->user_id = $id;
                //     $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                //     $back_role_edit_detail->save();
                //     if ($input['role_id'] == 1) {
                //         Session::flash('message', 'Your admin was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 2) {
                //         Session::flash('message', 'Your manager was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 3) {
                //         Session::flash('message', 'Your staff was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     }
                // } else if ($old_name !== $new_name && $old_phone !== $new_phone) {
                //     $back_role_edit_detail = new BackroleEditdetail();
                //     $back_role_edit_detail->old_name = $old_name;
                //     $back_role_edit_detail->new_name = $new_name;
                //     $back_role_edit_detail->old_phone = $old_phone;
                //     $back_role_edit_detail->new_phone = $new_phone;
                //     $back_role_edit_detail->user_id = $id;
                //     $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                //     $back_role_edit_detail->save();
                //     if ($input['role_id'] == 1) {
                //         Session::flash('message', 'Your admin was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 2) {
                //         Session::flash('message', 'Your manager was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 3) {
                //         Session::flash('message', 'Your staff was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     }
                // } else if ($old_name !== $new_name && $old_role_id !== $new_role_id) {
                //     $back_role_edit_detail = new BackroleEditdetail();
                //     $back_role_edit_detail->old_name = $old_name;
                //     $back_role_edit_detail->new_name = $new_name;
                //     $back_role_edit_detail->old_role_id = $old_role_id;
                //     $back_role_edit_detail->new_role_id = $new_role_id;
                //     $back_role_edit_detail->user_id = $id;
                //     $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                //     $back_role_edit_detail->save();
                //     if ($input['role_id'] == 1) {
                //         Session::flash('message', 'Your admin was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 2) {
                //         Session::flash('message', 'Your manager was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 3) {
                //         Session::flash('message', 'Your staff was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     }
                // } else if ($old_phone !== $new_phone && $old_role_id !== $new_role_id) {
                //     $back_role_edit_detail = new BackroleEditdetail();
                //     $back_role_edit_detail->old_phone = $old_phone;
                //     $back_role_edit_detail->new_phone = $new_phone;
                //     $back_role_edit_detail->old_role_id = $old_role_id;
                //     $back_role_edit_detail->new_role_id = $new_role_id;
                //     $back_role_edit_detail->user_id = $id;
                //     $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                //     $back_role_edit_detail->save();
                //     if ($input['role_id'] == 1) {
                //         Session::flash('message', 'Your admin was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 2) {
                //         Session::flash('message', 'Your manager was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 3) {
                //         Session::flash('message', 'Your staff was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     }
                // } else if ($old_name !== $new_name) {
                //     $back_role_edit_detail = new BackroleEditdetail();
                //     $back_role_edit_detail->old_name = $old_name;
                //     $back_role_edit_detail->new_name = $new_name;
                //     $back_role_edit_detail->user_id = $id;
                //     $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;

                //     $back_role_edit_detail->save();

                //     if ($input['role_id'] == 1) {
                //         Session::flash('message', 'Your admin was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 2) {
                //         Session::flash('message', 'Your manager was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 3) {
                //         Session::flash('message', 'Your staff was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     }
                // } else if ($old_phone !== $new_phone) {
                //     $back_role_edit_detail = new BackroleEditdetail();
                //     $back_role_edit_detail->old_phone = $old_phone;
                //     $back_role_edit_detail->new_phone = $new_phone;
                //     $back_role_edit_detail->user_id = $id;
                //     $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                //     $back_role_edit_detail->save();
                //     if ($input['role_id'] == 1) {
                //         Session::flash('message', 'Your admin was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 2) {
                //         Session::flash('message', 'Your manager was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 3) {
                //         Session::flash('message', 'Your staff was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     }
                // } else if ($old_role_id !== $new_role_id) {
                //     $back_role_edit_detail = new BackroleEditdetail();
                //     $back_role_edit_detail->old_role_id = $old_role_id;
                //     $back_role_edit_detail->new_role_id = $new_role_id;
                //     $back_role_edit_detail->user_id = $id;
                //     $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                //     $back_role_edit_detail->save();
                //     if ($input['role_id'] == 1) {
                //         Session::flash('message', 'Your admin was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 2) {
                //         Session::flash('message', 'Your manager was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     } else if ($input['role_id'] == 3) {
                //         Session::flash('message', 'Your staff was successfully updated');
                //         return redirect('/backside/shop_owner/users');
                //     }
                // } else if ($input['role_id'] == 1) {
                //     Session::flash('message', 'Your admin was successfully updated');
                //     return redirect('/backside/shop_owner/users');
                // } else if ($input['role_id'] == 2) {
                //     Session::flash('message', 'Your manager was successfully updated');
                //     return redirect('/backside/shop_owner/users');
                // } else if ($input['role_id'] == 3) {
                //     Session::flash('message', 'Your staff was successfully updated');
                //     return redirect('/backside/shop_owner/users');
                // }
                Session::flash('message', 'Your staff was successfully updated');
                return redirect('/backside/shop_owner/users');
            }
        }
    }

    public function remove_user($id)
    {
        $shop_id = $this->get_shopid();

        $forlog = ShopOwnersAndStaffs::where('shop_id', $shop_id)->where('id', $id)->first();
        $to_delete = ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->where('id', $id);
        $this->authorize('to_create_user', $forlog->role_id);

        $to_delete->delete();
        // \BackroleLogActivity::BackroleDeleteLog($manager_log,$shop_id);

        return redirect('/backside/shop_owner/users');
    }

    public function trash()
    {
        if (Auth::guard('shop_role')->check()) {
            $this->role('shop_role');
            $this->role_check_trash(Auth::user()->role_id);
            return view('backend.shopowner.manager.restore_list', ['shopowner' => $this->current_shop_data(), 'manager' => $this->role_user]);
        }
        $this->role('shop_owner');
        $manager = ShopOwnersAndStaffs::onlyTrashed()->where('shop_id', $this->role)->get();
        return view('backend.shopowner.manager.restore_list', ['shopowner' => $this->current_shop_data(), 'manager' => $manager]);
    }

    public function restore($id)
    {

        $user_url = ShopOwnersAndStaffs::onlyTrashed()->findOrFail($id)->shop_id;
        $role_id = ShopOwnersAndStaffs::onlyTrashed()->findOrFail($id)->role_id;
        Gate::authorize('to_create_user', $role_id);

        return redirect()->back();
    }
}
