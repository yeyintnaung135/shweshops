<?php

namespace App\Http\Controllers\ShopOwner;

use App\Models\Role;
use App\Models\ShopOwnersAndStaffs;
use App\Models\Shops;
use App\Models\ShopownerLogActivity;
use App\Models\ItemLogActivity;
use App\Models\BackroleLogActivity;
use App\Models\BackroleEditDetail;
use App\Models\ItemsEditDetailLogs;
use App\Facade\TzGate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Trait\UserRole;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class ManagerController extends Controller
{
    use UserRole;

    public function __construct()
    {
        $this->middleware('auth:shop_owners_and_staffs');
    }


    public function list()
    {
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

        $shop_id = 1;

        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;
        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }

        $totalRecords = ShopownerLogActivity::select('count(*) as allcount')
            ->where('shop_id', $shop_id)
            ->where(function ($query) use ($searchValue) {
                $query->where('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('item_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('role', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = ShopownerLogActivity::orderBy($columnName, $columnSortOrder)
            ->where('shop_id', $shop_id)->orderBy('created_at', 'desc')
            ->where(function ($query) use ($searchValue) {
                $query->where('product_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('item_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('role', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('shopowner_log_activities.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "product_code" => $record->product_code,
                "item_name" => $record->item_name,
                "user_name" => $record->user_name,
                "action" => $record->action,
                "btn" => $record->id,
                "role" => $record->role,
                // "created_at" => date('F d, Y ( h:i A )',strtotime($record->created_at)),
                "created_at" => $record->created_at->format('d-m-Y H:i:s'),
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

    // datable for backrole log activity
    public function get_back_role_activity(Request $request)
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

        $shop_id = 1;

        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;
        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }


        $totalRecords = BackroleLogActivity::select('count(*) as allcount')
            ->where('shop_id', $shop_id)
            ->where(function ($query) use ($searchValue) {
                $query->where('user_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_role', 'like', '%' . $searchValue . '%')
                    ->orWhere('action', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('role', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;


        $records = BackroleLogActivity::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where('shop_id', $shop_id)
            ->where(function ($query) use ($searchValue) {
                $query->where('user_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_role', 'like', '%' . $searchValue . '%')
                    ->orWhere('action', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('role', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('backrole_log_activities.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "user_name" => $record->user_name,
                "user_role" => $record->user_role,
                "action" => $record->action,
                "name" => $record->name,
                "role" => $record->role,
                "btn" => $record->id,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->created_at)),
                // "created_at" => $record->created_at,
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

        if (Auth::guard('shop_role')->check()) {
            $users = ShopOwnersAndStaffs::orderBy($columnName, $columnSortOrder)
                ->where('shop_id', Auth::user()->role_id)
                ->whereIn('role_id', [3])
                ->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('phone', 'like', '%' . $searchValue . '%')
                ->select('manager.*')
                ->skip($start)
                ->take($rowperpage)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $this->role('shop_owner');
            $users = ShopOwnersAndStaffs::orderBy($columnName, $columnSortOrder)
                ->where('shop_id', $this->role)
                ->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('phone', 'like', '%' . $searchValue . '%')
                ->select('manager.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
            // $shopowner = $this->shop_owner;
            // $users = $role_users;
        }

        $totalRecords = count($users);
        $totalRecordswithFilter = count($users);

        $data_arr = array();

        foreach ($users as $user) {
            $data_arr[] = array(
                "id" => $user->id,
                "name" => $user->name,
                "phone" => $user->phone,
                "role" => $user->role->name,
                "action" => $user->id,
                "created_at" => $user->created_at
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
        $this->authorize('to_create_user', 3);

        $role = Role::all();
        //tz
        if ($this->is_admin() or $this->is_manager()) {

            if ($this->is_admin()) {
                $role = Role::whereIn('id', [2, 3])->orderBy('created_at', 'desc')->get();
            } else {

                $role = Role::where(['id' => 3])->orderBy('created_at', 'desc')->get();
            }
        }
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
                return redirect('/backside/shop_owner/users');
            } else if ($input['role_id'] == 2) {
                Session::flash('message', 'Your manager was successfully added');
                return redirect('/backside/shop_owner/users');
            } else if ($input['role_id'] == 3) {
                Session::flash('message', 'Your staff was successfully added');
                return redirect('/backside/shop_owner/users');
            }
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
            'role_id' => ['required', 'max:255', Rule::in('1', '2', '3', '4')],

            //rules
            'phone' => [
                'required',
                Rule::unique('shops', 'main_phone')->ignore($manager->id),
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
            return view('backend.shopowner.manager.restore_list', ['shopowner' => $this->shop_owner, 'manager' => $this->role_user]);
        }
        $this->role('shop_owner');
        $manager = ShopOwnersAndStaffs::onlyTrashed()->where('shop_id', $this->role)->get();
        return view('backend.shopowner.manager.restore_list', ['shopowner' => $this->shop_owner, 'manager' => $manager]);
    }

    public function get_users_trash(Request $request)
    {
    }

    public function restore($id)
    {

        $user_url = ShopOwnersAndStaffs::onlyTrashed()->findOrFail($id)->shop_id;
        $role_id = ShopOwnersAndStaffs::onlyTrashed()->findOrFail($id)->role_id;
        if (Auth::guard('shop_role')->check()) {
            $this->role('shop_role');

            if (TzGate::allows($user_url == $this->role_shop_id, $role_id)) {
                ShopOwnersAndStaffs::onlyTrashed()->findOrFail($id)->restore();
            }
        } else {
            $this->role('shop_owner');
            if (TzGate::allows($user_url == $this->role)) {
                ShopOwnersAndStaffs::onlyTrashed()->findOrFail($id)->restore();
            }
        }


        return redirect()->back();
    }

    public function restore_all()
    {

        return back();
    }
}
