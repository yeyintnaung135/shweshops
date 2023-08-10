<?php

namespace App\Http\Controllers\ShopOwner;

use App\Facade\TzGate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\MultipleItem;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Controllers\Trait\YKImage;
use App\Models\BackRoleEditDetail;
use App\Models\Category;
use App\Models\Item;
use App\Models\PosAssignGoldPrice;
use App\Models\PosCounterShop;
use App\Models\PosCreditList;
use App\Models\PosDiamond;
use App\Models\PosGoldSale;
use App\Models\PosKyoutPurchase;
use App\Models\PosKyoutSale;
use App\Models\PosPlatinumPurchase;
use App\Models\PosPlatinumSale;
use App\Models\PosPurchase;
use App\Models\PosPurchaseSale;
use App\Models\PosReturnList;
use App\Models\PosStaff;
use App\Models\PosSupplier;
use App\Models\PosWhiteGoldPurchase;
use App\Models\PosWhiteGoldSale;
use App\Models\Role;
use App\Models\ShopBanner;
use App\Models\ShopOwner;
use App\Models\State;
use App\Models\Township;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PosSecondPhaseController extends Controller
{
    use YKImage, UserRole, MultipleItem;

    public $err_data = [];

    public function __construct()
    {
        $this->middleware('auth:shop_owner,shop_role');
    }

//Staff
    public function get_staff_list()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $staffs = PosStaff::where('shop_id', $this->getshopid())->get();
        return view('backend.pos.staff_list', ['shopowner' => $shopowner, 'staffs' => $staffs]);
    }
    public function get_create_staff()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->getshopid())->get();
        $role = Role::all();
        return view('backend.pos.create_staff', ['shopowner' => $shopowner, 'counters' => $counters, 'role' => $role]);
    }

    public function staff_type_filter(Request $request)
    {
        $data = PosStaff::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_id', $this->getshopid())->get();
        return response()->json($data);
    }

    public function store_staff(Request $request)
    {
        // dd($request->all());
        //manager

        if ($this->isstaff()) {
            return $this->unauthorize();
        }
        $input = $request->except('_token');

        $rules = [

            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            //rules
            'phone' => 'unique:manager|unique:shop_owners,main_phone',

        ];
        if (isset(Auth::guard('shop_role')->user()->id)) {
            $this->role('shop_role');

            $input['shop_id'] = $this->role_shop_id;
            $shop_id = $this->role_shop_id;
        } else {
            $input['shop_id'] = Auth::guard('shop_owner')->user()->id;
            $shop_id = Auth::guard('shop_owner')->user()->id;
        }
        \BackroleLogActivity::BackroleCreateLog($input, $shop_id);

        $input['password'] = Hash::make($input['password']);
        $validate = Validator::make($input, $rules);
        $count = PosStaff::where('code_number', $request->code_number)->where('shop_id', $this->getshopid())->count();
        if ($count >= 1) {
            Session::flash('message', 'Must not be same Code Number!');

            return redirect()->route('backside.shop_owner.pos.create_staff');
        }

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        } elseif (PosStaff::insert($input)) {
            if ($input['role_id'] == 1) {
                Session::flash('message', 'Your admin was successfully added');
                return redirect()->route('backside.shop_owner.pos.staff_list');
            } else if ($input['role_id'] == 2) {
                Session::flash('message', 'Your manager was successfully added');
                return redirect()->route('backside.shop_owner.pos.staff_list');
            } else if ($input['role_id'] == 3) {
                Session::flash('message', 'Your staff was successfully added');
                return redirect()->route('backside.shop_owner.pos.staff_list');
            }

        }
        //end
    }

    public function edit_staff($id)
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $staff = PosStaff::where('id', $id)->first();
        $counters = PosCounterShop::where('shop_owner_id', $this->getshopid())->get();
        $role = Role::all();
        return view('backend.pos.edit_staff', ['shopowner' => $shopowner, 'staff' => $staff, 'counters' => $counters, 'role' => $role]);
    }

    public function update_staff(Request $request, $id)
    {
        if (isset(Auth::guard('shop_role')->user()->id)) {
            $this->role('shop_role');
            $shop_id = $this->role_shop_id;
        } else {
            $shop_id = Auth::guard('shop_owner')->user()->id;
        }

        //remove token and method from request
        $input = $request->except('_token', '_method');

        $manager = PosStaff::where('id', $id)->first();

        //  return dd($role->name);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'string', 'max:255'],

            //rules
            'phone' => [
                'required',
                Rule::unique('shop_owners', 'main_phone')->ignore($manager->id),
                Rule::unique('manager')->ignore($manager->id),
            ],

        ];
        $validate = Validator::make($input, $rules);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        } else {

            if (PosStaff::where('id', $id)->update($input)) {
                $backroleid = \BackroleLogActivity::BackroleEditLog($input, $shop_id);

                $old_name = $manager->name;
                $old_phone = $manager->phone;
                $old_role = Role::where('id', $manager->role_id)->first();
                $old_role_id = $old_role->name;
                // return dd($old_role_id);

                $new_name = $request['name'];
                $new_phone = $request['phone'];
                $new = $request['role_id'];
                $new_role = Role::where('id', $new)->first();
                $new_role_id = $new_role->name;
                // return dd($new_role_id);

                if ($old_name == $new_name && $old_phone == $new_phone && $old_role_id == $new_role_id) {
                    // return dd($old_name,$new_name,$old_phone,$new_phone,$old_role_id,$new_role_id);
                    $back_role_edit_detail = new BackRoleEditDetail();
                    $back_role_edit_detail->old_name = "no";
                    $back_role_edit_detail->new_name = "no";
                    $back_role_edit_detail->old_phone = "no";
                    $back_role_edit_detail->new_phone = "no";
                    $back_role_edit_detail->old_role_id = "no";
                    $back_role_edit_detail->new_role_id = "no";
                    $back_role_edit_detail->user_id = $id;
                    $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                    $back_role_edit_detail->save();
                    if ($input['role_id'] == 1) {
                        Session::flash('message', 'Your admin was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 2) {
                        Session::flash('message', 'Your manager was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 3) {
                        Session::flash('message', 'Your staff was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    }
                } else if ($old_name !== $new_name && $old_phone !== $new_phone && $old_role_id !== $new_role_id) {
                    // return dd($old_name,$new_name,$old_phone,$new_phone,$old_role_id,$new_role_id);
                    $back_role_edit_detail = new BackRoleEditDetail();
                    $back_role_edit_detail->old_name = $old_name;
                    $back_role_edit_detail->new_name = $new_name;
                    $back_role_edit_detail->old_phone = $old_phone;
                    $back_role_edit_detail->new_phone = $new_phone;
                    $back_role_edit_detail->old_role_id = $old_role_id;
                    $back_role_edit_detail->new_role_id = $new_role_id;
                    $back_role_edit_detail->user_id = $id;
                    $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                    $back_role_edit_detail->save();
                    if ($input['role_id'] == 1) {
                        Session::flash('message', 'Your admin was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 2) {
                        Session::flash('message', 'Your manager was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 3) {
                        Session::flash('message', 'Your staff was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    }
                } else if ($old_name !== $new_name && $old_phone !== $new_phone) {
                    $back_role_edit_detail = new BackRoleEditDetail();
                    $back_role_edit_detail->old_name = $old_name;
                    $back_role_edit_detail->new_name = $new_name;
                    $back_role_edit_detail->old_phone = $old_phone;
                    $back_role_edit_detail->new_phone = $new_phone;
                    $back_role_edit_detail->user_id = $id;
                    $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                    $back_role_edit_detail->save();
                    if ($input['role_id'] == 1) {
                        Session::flash('message', 'Your admin was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 2) {
                        Session::flash('message', 'Your manager was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 3) {
                        Session::flash('message', 'Your staff was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    }

                } else if ($old_name !== $new_name && $old_role_id !== $new_role_id) {
                    $back_role_edit_detail = new BackRoleEditDetail();
                    $back_role_edit_detail->old_name = $old_name;
                    $back_role_edit_detail->new_name = $new_name;
                    $back_role_edit_detail->old_role_id = $old_role_id;
                    $back_role_edit_detail->new_role_id = $new_role_id;
                    $back_role_edit_detail->user_id = $id;
                    $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                    $back_role_edit_detail->save();
                    if ($input['role_id'] == 1) {
                        Session::flash('message', 'Your admin was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 2) {
                        Session::flash('message', 'Your manager was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 3) {
                        Session::flash('message', 'Your staff was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    }

                } else if ($old_phone !== $new_phone && $old_role_id !== $new_role_id) {
                    $back_role_edit_detail = new BackRoleEditDetail();
                    $back_role_edit_detail->old_phone = $old_phone;
                    $back_role_edit_detail->new_phone = $new_phone;
                    $back_role_edit_detail->old_role_id = $old_role_id;
                    $back_role_edit_detail->new_role_id = $new_role_id;
                    $back_role_edit_detail->user_id = $id;
                    $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                    $back_role_edit_detail->save();
                    if ($input['role_id'] == 1) {
                        Session::flash('message', 'Your admin was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 2) {
                        Session::flash('message', 'Your manager was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 3) {
                        Session::flash('message', 'Your staff was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    }

                } else if ($old_name !== $new_name) {
                    $back_role_edit_detail = new BackRoleEditDetail();
                    $back_role_edit_detail->old_name = $old_name;
                    $back_role_edit_detail->new_name = $new_name;
                    $back_role_edit_detail->user_id = $id;
                    $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;

                    $back_role_edit_detail->save();

                    if ($input['role_id'] == 1) {
                        Session::flash('message', 'Your admin was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 2) {
                        Session::flash('message', 'Your manager was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 3) {
                        Session::flash('message', 'Your staff was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    }

                } else if ($old_phone !== $new_phone) {
                    $back_role_edit_detail = new BackRoleEditDetail();
                    $back_role_edit_detail->old_phone = $old_phone;
                    $back_role_edit_detail->new_phone = $new_phone;
                    $back_role_edit_detail->user_id = $id;
                    $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                    $back_role_edit_detail->save();
                    if ($input['role_id'] == 1) {
                        Session::flash('message', 'Your admin was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 2) {
                        Session::flash('message', 'Your manager was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 3) {
                        Session::flash('message', 'Your staff was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    }
                } else if ($old_role_id !== $new_role_id) {
                    $back_role_edit_detail = new BackRoleEditDetail();
                    $back_role_edit_detail->old_role_id = $old_role_id;
                    $back_role_edit_detail->new_role_id = $new_role_id;
                    $back_role_edit_detail->user_id = $id;
                    $back_role_edit_detail->backrole_log_activities_id = $backroleid->id;
                    $back_role_edit_detail->save();
                    if ($input['role_id'] == 1) {
                        Session::flash('message', 'Your admin was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 2) {
                        Session::flash('message', 'Your manager was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    } else if ($input['role_id'] == 3) {
                        Session::flash('message', 'Your staff was successfully updated');
                        return redirect()->route('backside.shop_owner.pos.staff_list');
                    }

                } else if ($input['role_id'] == 1) {
                    Session::flash('message', 'Your admin was successfully updated');
                    return redirect()->route('backside.shop_owner.pos.staff_list');
                } else if ($input['role_id'] == 2) {
                    Session::flash('message', 'Your manager was successfully updated');
                    return redirect()->route('backside.shop_owner.pos.staff_list');
                } else if ($input['role_id'] == 3) {
                    Session::flash('message', 'Your staff was successfully updated');
                    return redirect()->route('backside.shop_owner.pos.staff_list');
                }

            }

        }

    }

    public function delete_staff(Request $request)
    {
        $manager = PosStaff::where('id', $request->sid);

        $manager_log = PosStaff::where('id', $request->sid)->first();
        // dd($manager_log);

        if (Auth::guard('shop_role')->check()) {
            $this->role('shop_role');
            if (TzGate::allows($manager_log->shop_id == $this->role_shop_id, $manager_log->role_id)) {
                $manager->delete();
            }
            $shop_id = $this->role_shop_id;
        } else {
            $this->role('shop_owner');
            if (TzGate::allows($this->role == $manager_log->shop_id)) {
                $manager->delete();
            }
            $shop_id = "yahoo";
        }

        \BackroleLogActivity::BackroleDeleteLog($manager_log, $shop_id);

        Session::flash('message', 'Staff was successfully Deleted!');
        return response()->json([
            'data' => 'success',
        ], 200);
    }

    public function check_staff_code(Request $request)
    {
        // dd($request->code);
        $staff = PosStaff::where('code_number', $request->code)->where('shop_id', $this->getshopid())->count();
        if ($staff >= 1) {
            return response()->json([
                'data' => 0,
            ], 200);
        } else {
            return response()->json([
                'data' => 1,
            ], 200);
        }
    }

    //Supplier

    public function get_supplier_list()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $suppliers = PosSupplier::where('shop_owner_id', $this->getshopid())->get();

        return view('backend.pos.supplier_list', ['shopowner' => $shopowner, 'suppliers' => $suppliers]);
    }

    public function get_create_supplier()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $state = State::all();
        $township = Township::all();
        return view('backend.pos.create_supplier', ['shopowner' => $shopowner, 'state' => $state, 'township' => $township]);
    }

    public function change_state(Request $request)
    {
        $township = Township::where('state_id', $request->sid)->get();
        return response()->json($township);
    }

    public function type_filter(Request $request)
    {
        if ($request->type == 1) {
            $type = explode('/', $request->text);
            $types = [];
            foreach ($type as $t) {
                $sup = PosSupplier::where('type', 'like', '%' . $t . '%')->where('shop_owner_id', $this->getshopid())->get();
                array_push($types, $sup);
            }
            foreach ($types as $tp) {
                $data = collect($tp)->unique('id')->all();
            }
        }
        if ($request->type == 2) {
            $data = PosSupplier::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id', $this->getshopid())->get();
        }

        return response()->json($data);
    }

    public function store_supplier(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->inlineCheckbox1) {$inlineCheckbox1 = $request->inlineCheckbox1;} else { $inlineCheckbox1 = 'no';}
        if ($request->inlineCheckbox2) {$inlineCheckbox2 = $request->inlineCheckbox2;} else { $inlineCheckbox2 = 'no';}
        if ($request->inlineCheckbox3) {$inlineCheckbox3 = $request->inlineCheckbox3;} else { $inlineCheckbox3 = 'no';}
        if ($request->inlineCheckbox4) {$inlineCheckbox4 = $request->inlineCheckbox4;} else { $inlineCheckbox4 = 'no';}
        $supplier = PosSupplier::create([
            'code_number' => $request->code_number,
            'date' => $request->date,
            'shop_owner_id' => $this->getshopid(),
            'name' => $request->name,
            'shop_name' => $request->shop_name,
            'shop_type' => $request->shop_type,
            'phone' => $request->phone,
            'other_phone' => $request->other_phone,
            'state_id' => $request->state,
            'township_id' => $request->township,
            'address' => $request->address,
            'remark' => $request->remark,
            'type' => $inlineCheckbox1 . '/' .
            $inlineCheckbox2 . '/' .
            $inlineCheckbox3 . '/' .
            $inlineCheckbox4,
        ]);

        Session::flash('message', 'Supplier was successfully Created!');

        return redirect()->route('backside.shop_owner.pos.supplier_list');

    }

    public function edit_supplier($id)
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $supplier = PosSupplier::find($id);
        $state = State::all();
        $township = Township::all();
        return view('backend.pos.edit_supplier', ['shopowner' => $shopowner, 'supplier' => $supplier, 'state' => $state, 'township' => $township]);
    }

    public function update_supplier(Request $request, $id)
    {
        // dd($request->all());
        try {
            if ($request->inlineCheckbox1) {$inlineCheckbox1 = $request->inlineCheckbox1;} else { $inlineCheckbox1 = 'no';}
            if ($request->inlineCheckbox2) {$inlineCheckbox2 = $request->inlineCheckbox2;} else { $inlineCheckbox2 = 'no';}
            if ($request->inlineCheckbox3) {$inlineCheckbox3 = $request->inlineCheckbox3;} else { $inlineCheckbox3 = 'no';}
            if ($request->inlineCheckbox4) {$inlineCheckbox4 = $request->inlineCheckbox4;} else { $inlineCheckbox4 = 'no';}
            $supplier = PosSupplier::find($id);
            $supplier->code_number = $request->code_number;
            $supplier->name = $request->name;
            $supplier->shop_name = $request->shop_name;
            $supplier->date = $request->date;
            $supplier->shop_type = $request->shop_type;
            $supplier->other_phone = $request->other_phone;
            $supplier->state_id = $request->state;
            $supplier->township_id = $request->township;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->remark = $request->remark;
            $supplier->type = $inlineCheckbox1 . '/' .
                $inlineCheckbox2 . '/' .
                $inlineCheckbox3 . '/' .
                $inlineCheckbox4;
            $supplier->save();
            Session::flash('message', 'Supplier was successfully Edited!');
            return redirect()->route('backside.shop_owner.pos.supplier_list');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function delete_supplier(Request $request)
    {
        $supplier = PosSupplier::find($request->sid);
        $purchase = PosPurchase::where('supplier_id', $supplier->id)->delete();
        $kpurchase = PosKyoutPurchase::where('supplier_id', $supplier->id)->delete();
        $supplier->delete();
        Session::flash('message', 'Supplier was successfully Deleted!');
        return response()->json([
            'data' => 'success',
        ], 200);
    }

    //Return
    public function return_list()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $lists = PosReturnList::where('shop_owner_id', $this->getshopid())->get();
        return view('backend.pos.return_list', ['shopowner' => $shopowner, 'lists' => $lists]);
    }
    public function return_type_filter(Request $request)
    {
        $data = PosReturnList::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id', $this->getshopid())->with('category')->get();
        return response()->json($data);
    }
    public function create_return()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->getshopid())->first();
        $categories = Category::all();
        $quality = DB::table('pos_qualities')->get();
        $diamonds = PosDiamond::where('shop_owner_id', $this->getshopid())->get();
        return view('backend.pos.create_return', ['shopowner' => $shopowner, 'diamonds' => $diamonds, 'assign_gold_price' => $assign_gold_price, 'categories' => $categories, 'quality' => $quality]);
    }
    public function store_return(Request $request)
    {
        try {
            if ($request->hasfile('photo')) {
                $image = $request->file('photo');
                $filename = time() . "-" . $image->getClientOriginalName();
                // $image->move(public_path() . '/pos/return_photo/', $filename);
                if (env('USE_DO') != 'true') {
                    // dd('false');
                    $get_path = $image->move(public_path('main/images/pos/return_photo/'), $filename);
                } else {
                    // dd('true');
                    Storage::disk('digitalocean')->put('/prod/pos/return_photo/' . $filename, file_get_contents($image));
                }
            } else {
                $filename = 'default.png';
            }
            $diamonds = '';
            if ($request->include_diamonds) {
                foreach ($request->include_diamonds as $diamond) {
                    $diamonds .= $diamond . ',';
                }
            }

            $counts = '';
            if ($request->counts) {
                foreach ($request->counts as $count) {
                    $counts .= $count . ',';
                }
            }

            $carrats = '';
            if ($request->carrats) {
                foreach ($request->carrats as $carrat) {
                    $carrats .= $carrat . ',';
                }
            }

            $yaties = '';
            if ($request->yaties) {
                foreach ($request->yaties as $yatie) {
                    $yaties .= $yatie . ',';
                }
            }

            $bes = '';
            if ($request->bes) {
                foreach ($request->bes as $be) {
                    $bes .= $be . ',';
                }
            }

            //  dd($request->all());
            $return = PosReturnList::create([
                'date' => $request->date,
                'shop_owner_id' => $this->getshopid(),
                'quality_id' => $request->quality,
                'category_id' => $request->category_id,
                'product_gram_kyat_pe_yway' => $request->product_gram . '/' . $request->product_kyat . '/' . $request->product_pe . '/' . $request->product_yway,
                //  'gold_price' => $request->gold_price,
                'gold_fee' => $request->gold_fee,
                'remark' => $request->remark,
                'customer_name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'diamonds' => $diamonds,
                'counts' => $counts,
                'carrats' => $carrats,
                'yaties' => $yaties,
                'bes' => $bes,
                'product_type' => $request->product_type,
                'photo' => $filename,
            ]);
            // $return = PosReturnList::first();
            $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $counters = PosCounterShop::where('shop_owner_id', $this->getshopid())->get();
            $code = "RTN-" . date('dmY') . "-" . sprintf("%04s", ($return->id + 1));
            Session::flash('message', 'Return was successfully Created!');

            return view('backend.pos.return_voucher_list', ['shopowner' => $shopowner, 'code' => $code, 'return' => $return, 'counters' => $counters]);
        } catch (\Exception $e) {
            Session::flash('alert-class', 'Something Wrong!');
            return redirect()->back();
        }
    }
    public function update_return($id, Request $request)
    {
        // dd($request->all());
        try {
            if ($request->hasfile('photo')) {
                $image = $request->file('photo');
                $filename = time() . "-" . $image->getClientOriginalName();
                // $image->move(public_path() . '/pos/return_photo/', $filename);
                if (env('USE_DO') != 'true') {
                    // dd('false');
                    $get_path = $image->move(public_path('main/images/pos/return_photo/'), $filename);
                } else {
                    // dd('true');
                    Storage::disk('digitalocean')->put('/prod/pos/return_photo/' . $filename, file_get_contents($image));
                }
            } else {
                $filename = 'default.png';
            }
            $diamonds = '';
            foreach ($request->diamond_name as $diamond) {
                $diamonds .= $diamond . ',';
            }
            $counts = '';
            foreach ($request->counts as $count) {
                $counts .= $count . ',';
            }
            $carrats = '';
            foreach ($request->carrats as $carrat) {
                $carrats .= $carrat . ',';
            }
            $yaties = '';
            foreach ($request->yaties as $yatie) {
                $yaties .= $yatie . ',';
            }
            $bes = '';
            foreach ($request->bes as $be) {
                $bes .= $be . ',';
            }
            //  dd($request->all());
            $purchase = PosReturnList::find($id);
            //  dd($purchase);
            $purchase->date = $request->date;
            $purchase->quality_id = $request->quality;
            $purchase->category_id = $request->category_id;
            $purchase->product_gram_kyat_pe_yway = $request->product_gram . '/' . $request->product_kyat . '/' . $request->product_pe . '/' . $request->product_yway;
            //  'gold_price = $request->gold_price;
            $purchase->gold_fee = $request->gold_fee;
            $purchase->remark = $request->remark;
            $purchase->customer_name = $request->name;
            $purchase->phone = $request->phone;
            $purchase->address = $request->address;
            $purchase->diamonds = $diamonds;
            $purchase->counts = $counts;
            $purchase->carrats = $carrats;
            $purchase->yaties = $yaties;
            $purchase->bes = $bes;
            $purchase->product_type = $request->product_type;
            $purchase->photo = $filename;
            $purchase->save();

            Session::flash('message', 'Return was successfully Updated!');

            return redirect()->route('backside.shop_owner.pos.return_list');
        } catch (\Exception $e) {
            Session::flash('alert-class', 'Something Wrong!');
            return redirect()->back();
        }
    }
    public function edit_return($id)
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $return = PosReturnList::where('id', $id)->first();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->getshopid())->first();
        $categories = Category::all();
        $quality = DB::table('pos_qualities')->get();
        $diamonds = PosDiamond::where('shop_owner_id', $this->getshopid())->get();
        return view('backend.pos.edit_return', ['shopowner' => $shopowner, 'return' => $return, 'diamonds' => $diamonds, 'assign_gold_price' => $assign_gold_price, 'categories' => $categories, 'quality' => $quality]);
    }
    public function delete_return(Request $request)
    {
        $return = DB::table('pos_return_lists')->where('id', $request->sid)->delete();
        Session::flash('message', 'Return List was successfully Deleted!');
        return response()->json([
            'data' => 'success',
        ], 200);
    }
    public function add_purchase_return(Request $request)
    {
        $return = PosReturnList::find($request->id);
        if ($return->product_type == 'ရွှေ') {
            $purchase = PosPurchase::create([
                'date' => $return->date,
                'shop_owner_id' => $this->getshopid(),
                'quality_id' => $return->quality_id,
                'purchase_price' => $return->gold_fee,
                'category_id' => $return->category_id,
                'product_gram_kyat_pe_yway' => $return->product_gram_kyat_pe_yway,
                'gold_price' => $return->gold_price,
                'gold_fee' => $return->gold_fee,
                'remark' => $return->remark,
                'photo' => $return->photo,
            ]);
            $return->add_flag = 1;
            $return->save();
        }
        Session::flash('message', 'Return List was successfully Added to Purchase List!');
        return response()->json([
            'data' => 'success',
        ], 200);
    }
    //Filter
    public function filter_sell_flag(Request $request)
    {
        if ($request->val == 1) {
            if ($request->text == 'အားလုံး') {
                $purchase = PosPurchase::where('shop_owner_id', $this->getshopid())->get();
            } else {
                $purchase = PosPurchase::where('counter_shop', $request->text)->where('shop_owner_id', $this->getshopid())->get();
            }
        }
        if ($request->val == 2) {
            if ($request->text == 'အားလုံး') {
                $purchase = PosKyoutPurchase::where('shop_owner_id', $this->getshopid())->get();
            } else {
                $purchase = PosKyoutPurchase::where('counter_shop', $request->text)->where('shop_owner_id', $this->getshopid())->get();
            }
        }
        if ($request->val == 3) {
            if ($request->text == 'အားလုံး') {
                $purchase = PosPlatinumPurchase::where('shop_owner_id', $this->getshopid())->get();
            } else {
                $purchase = PosPlatinumPurchase::where('counter_shop', $request->text)->where('shop_owner_id', $this->getshopid())->get();
            }
        }
        if ($request->val == 4) {
            if ($request->text == 'အားလုံး') {
                $purchase = PosWhiteGoldPurchase::where('shop_owner_id', $this->getshopid())->get();
            } else {
                $purchase = PosWhiteGoldPurchase::where('counter_shop', $request->text)->where('shop_owner_id', $this->getshopid())->get();
            }
        }
        return response()->json([
            'data' => $purchase,
        ], 200);
    }
    public function filter_sold(Request $request)
    {
        if ($request->val == 1) {
            if ($request->text == 'အားလုံး') {
                $sale = PosGoldSale::where('shop_owner_id', $this->getshopid())->get();
            } else {
                $sale = PosGoldSale::where('counter_shop', $request->text)->where('shop_owner_id', $this->getshopid())->get();
            }
        }
        if ($request->val == 2) {
            if ($request->text == 'အားလုံး') {
                $sale = PosKyoutSale::where('shop_owner_id', $this->getshopid())->get();
            } else {
                $sale = PosKyoutSale::where('counter_shop', $request->text)->where('shop_owner_id', $this->getshopid())->get();
            }
        }
        if ($request->val == 3) {
            if ($request->text == 'အားလုံး') {
                $sale = PosPlatinumSale::where('shop_owner_id', $this->getshopid())->get();
            } else {
                $sale = PosPlatinumSale::where('counter_shop', $request->text)->where('shop_owner_id', $this->getshopid())->get();
            }
        }
        if ($request->val == 4) {
            if ($request->text == 'အားလုံး') {
                $sale = PosWhiteGoldSale::where('shop_owner_id', $this->getshopid())->get();
            } else {
                $sale = PosWhiteGoldSale::where('counter_shop', $request->text)->where('shop_owner_id', $this->getshopid())->get();
            }
        }
        return response()->json([
            'data' => $sale,
        ], 200);
    }
    //Credit List
    public function credit_list()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $credits = PosCreditList::where('shop_owner_id', $this->getshopid())->get();
        // dd($assign_gold_price);
        return view('backend.pos.credit_list', ['shopowner' => $shopowner, 'credits' => $credits]);
    }
    public function credittypeFilter(Request $request)
    {
        // dd($request->all());
        if ($request->type == 2) {
            $data = PosCreditList::whereBetween('purchase_date', [$request->start_date, $request->end_date])->where('shop_owner_id', $this->getshopid())->get();
        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function delete_credit(Request $request)
    {
        $credit = PosCreditList::find($request->id);
        $credit->delete();
        Session::flash('message', 'Credit Amount was successfully Paid!');
        return response()->json([
            'data' => 'success',
        ], 200);

    }
    //Second Phase
    //Purchases
    public function get_purchase_lists()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPurchase::where('shop_owner_id', $this->getshopid())->get();
        $kyoutpurchases = PosKyoutPurchase::where('shop_owner_id', $this->getshopid())->get();
        $platinumpurchases = PosPlatinumPurchase::where('shop_owner_id', $this->getshopid())->get();
        $whitegoldpurchases = PosWhiteGoldPurchase::where('shop_owner_id', $this->getshopid())->get();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->getshopid())->first();
        if ($assign_gold_price) {
            return view('backend.pos.purchase_lists', ['shopowner' => $shopowner, 'purchases' => $purchases, 'kyoutpurchases' => $kyoutpurchases, 'platinumpurchases' => $platinumpurchases, 'whitegoldpurchases' => $whitegoldpurchases]);
        } else {
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->getshopid())->first();
            return view('backend.pos.assign_gold_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
        }
    }
    //Sales
    public function get_sale_lists()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosGoldSale::where('shop_owner_id', $this->getshopid())->get();
        $kyoutpurchases = PosKyoutSale::where('shop_owner_id', $this->getshopid())->get();
        $platinumpurchases = PosPlatinumSale::where('shop_owner_id', $this->getshopid())->get();
        $whitegoldpurchases = PosWhiteGoldSale::where('shop_owner_id', $this->getshopid())->get();
        $qty = PosPurchaseSale::where('shop_owner_id', $this->getshopid())->get();
        $tot_qty = 0;
        foreach ($qty as $q) {
            $tot_qty += $q->qty;
        }
        $gtoday_income = PosGoldSale::where('shop_owner_id', $this->getshopid())->get();
        $ktoday_income = PosKyoutSale::where('shop_owner_id', $this->getshopid())->get();
        $ptoday_income = PosPlatinumSale::where('shop_owner_id', $this->getshopid())->get();
        $wtoday_income = PosWhiteGoldSale::where('shop_owner_id', $this->getshopid())->get();

        $subtotal = 0;
        foreach ($gtoday_income as $g) {
            $subtotal += $g->amount;
        }
        foreach ($ktoday_income as $k) {
            $subtotal += $k->amount;
        }
        foreach ($ptoday_income as $p) {
            $subtotal += $p->amount;
        }
        foreach ($wtoday_income as $w) {
            $subtotal += $w->amount;
        }

        return view('backend.pos.sale_lists', ['shopowner' => $shopowner, 'arr' => $subtotal, 'tot_qty' => $tot_qty, 'qty' => $qty, 'purchases' => $purchases, 'kyoutpurchases' => $kyoutpurchases, 'platinumpurchases' => $platinumpurchases, 'whitegoldpurchases' => $whitegoldpurchases, 'type' => 1]);
    }

    public function get_famous_sale_lists()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosGoldSale::where('shop_owner_id', $this->getshopid())->get();
        $kyoutpurchases = PosKyoutSale::where('shop_owner_id', $this->getshopid())->get();
        $platinumpurchases = PosPlatinumSale::where('shop_owner_id', $this->getshopid())->get();
        $whitegoldpurchases = PosWhiteGoldSale::where('shop_owner_id', $this->getshopid())->get();
        $qty = PosPurchaseSale::orderBy('qty', 'desc')->where('shop_owner_id', $this->getshopid())->get();
        $tot_qty = 0;
        foreach ($qty as $q) {
            $tot_qty += $q->qty;
        }
        $gtoday_income = PosGoldSale::where('shop_owner_id', $this->getshopid())->get();
        $ktoday_income = PosKyoutSale::where('shop_owner_id', $this->getshopid())->get();
        $ptoday_income = PosPlatinumSale::where('shop_owner_id', $this->getshopid())->get();
        $wtoday_income = PosWhiteGoldSale::where('shop_owner_id', $this->getshopid())->get();

        $categories = Category::all();

        $subtotal = 0;
        foreach ($gtoday_income as $g) {
            $subtotal += $g->amount;
        }
        foreach ($ktoday_income as $k) {
            $subtotal += $k->amount;
        }
        foreach ($ptoday_income as $p) {
            $subtotal += $p->amount;
        }
        foreach ($wtoday_income as $w) {
            $subtotal += $w->amount;
        }

        return view('backend.pos.famous_lists', ['shopowner' => $shopowner, 'categories' => $categories, 'arr' => $subtotal, 'tot_qty' => $tot_qty, 'qty' => $qty, 'purchases' => $purchases, 'kyoutpurchases' => $kyoutpurchases, 'platinumpurchases' => $platinumpurchases, 'whitegoldpurchases' => $whitegoldpurchases, 'type' => 2]);
    }

    public function get_income_lists()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosGoldSale::where('shop_owner_id', $this->getshopid())->get();
        $kyoutpurchases = PosKyoutSale::where('shop_owner_id', $this->getshopid())->get();
        $platinumpurchases = PosPlatinumSale::where('shop_owner_id', $this->getshopid())->get();
        $whitegoldpurchases = PosWhiteGoldSale::where('shop_owner_id', $this->getshopid())->get();
        $qty = PosPurchaseSale::where('shop_owner_id', $this->getshopid())->get();
        $tot_qty = 0;
        foreach ($qty as $q) {
            $tot_qty += $q->qty;
        }
        $gtoday_income = PosGoldSale::where('shop_owner_id', $this->getshopid())->get();
        $ktoday_income = PosKyoutSale::where('shop_owner_id', $this->getshopid())->get();
        $ptoday_income = PosPlatinumSale::where('shop_owner_id', $this->getshopid())->get();
        $wtoday_income = PosWhiteGoldSale::where('shop_owner_id', $this->getshopid())->get();

        $subtotal = 0;
        foreach ($gtoday_income as $g) {
            $subtotal += explode('/', $g->purchase->profit)[0];
        }
        foreach ($ktoday_income as $k) {
            $subtotal += explode('/', $k->purchase->profit)[0];
        }
        foreach ($ptoday_income as $p) {
            $subtotal += explode('/', $p->purchase->profit)[0];
        }
        foreach ($wtoday_income as $w) {
            $subtotal += explode('/', $w->purchase->profit)[0];
        }

        return view('backend.pos.sale_lists', ['shopowner' => $shopowner, 'arr' => $subtotal, 'tot_qty' => $tot_qty, 'qty' => $qty, 'purchases' => $purchases, 'kyoutpurchases' => $kyoutpurchases, 'platinumpurchases' => $platinumpurchases, 'whitegoldpurchases' => $whitegoldpurchases, 'type' => 3]);
    }

    public function tab_sale_lists(Request $request)
    {
        $subtotal = 0;
        $qty = 0;
        $qtyy = PosPurchaseSale::where('shop_owner_id', $this->getshopid())->where('type', $request->type)->get();
        foreach ($qtyy as $q) {
            $qty += $q->qty;
        }
        if ($request->type == 1) {
            $gtoday_income = PosGoldSale::where('shop_owner_id', $this->getshopid())->get();
            foreach ($gtoday_income as $g) {
                $subtotal += $g->amount;
            }
        }
        if ($request->type == 2) {
            $ktoday_income = PosKyoutSale::where('shop_owner_id', $this->getshopid())->get();
            foreach ($ktoday_income as $k) {
                $subtotal += $k->amount;
            }
        }
        if ($request->type == 3) {
            $ptoday_income = PosPlatinumSale::where('shop_owner_id', $this->getshopid())->get();
            foreach ($ptoday_income as $p) {
                $subtotal += $p->amount;
            }
        }
        if ($request->type == 4) {
            $wtoday_income = PosWhiteGoldSale::where('shop_owner_id', $this->getshopid())->get();
            foreach ($wtoday_income as $w) {
                $subtotal += $w->amount;
            }
        }
        return response()->json(['total' => $subtotal, 'qty' => $qty]);
    }
    public function tab_income_lists(Request $request)
    {
        $subtotal = 0;
        $qty = 0;
        $purchase = [];
        if ($request->type == 2 || $request->type == 1) {
            if ($request->start && $request->end) {
                $gtoday_income = PosGoldSale::where('shop_owner_id', $this->getshopid())->whereBetween('date', [$request->start, $request->end])->get();
            } else {
                $gtoday_income = PosGoldSale::where('shop_owner_id', $this->getshopid())->get();
            }
            foreach ($gtoday_income as $g) {
                $subtotal += explode('/', $g->purchase->profit)[0];
                $qty++;
                $wei1 = '';
                $weight1 = explode('/', $g->purchase->product_gram_kyat_pe_yway);
                if ($weight1[1] != 0 || $weight1[1] != '') {
                    $wei1 .= $weight1[1] . 'ကျပ်';
                }
                if ($weight1[2] != 0 || $weight1[2] != '') {
                    $wei1 .= $weight1[2] . 'ပဲ';
                }
                if ($weight1[3] != 0 || $weight1[3] != '') {
                    $wei1 .= $weight1[3] . 'ရွေး';
                }
                $obj1 = ['name' => $g->purchase->gold_name, 'code_number' => $g->purchase->code_number, 'qty' => 1, 'fee' => explode('/', $g->purchase->profit)[0], 'weight' => $wei1];
                // dd($obj1);
                if (!empty($purchase)) {
                    foreach ($purchase as $k => $v) {
                        if ($purchase[$k]['code_number'] == $g->purchase->code_number) {
                            $purchase[$k]['qty']++;
                        }
                    }
                    array_push($purchase, $obj1);
                } else {
                    array_push($purchase, $obj1);
                }
            }
        }
        if ($request->type == 3 || $request->type == 1) {
            if ($request->start && $request->end) {
                $ktoday_income = PosKyoutSale::where('shop_owner_id', $this->getshopid())->whereBetween('date', [$request->start, $request->end])->get();
            } else {
                $ktoday_income = PosKyoutSale::where('shop_owner_id', $this->getshopid())->get();
            }
            foreach ($ktoday_income as $k) {
                $subtotal += explode('/', $k->purchase->profit)[0];
                $qty++;
                $wei2 = '';
                $weight2 = explode('/', $k->purchase->gold_gram_kyat_pe_yway);
                if ($weight2[1] != 0 || $weight2[1] != '') {
                    $wei2 .= $weight2[1] . 'ကျပ်';
                }
                if ($weight2[2] != 0 || $weight2[2] != '') {
                    $wei2 .= $weight2[2] . 'ပဲ';
                }
                if ($weight2[3] != 0 || $weight2[3] != '') {
                    $wei2 .= $weight2[3] . 'ရွေး';
                }
                $obj2 = ['name' => $k->purchase->gold_name, 'code_number' => $k->purchase->code_number, 'qty' => 1, 'fee' => explode('/', $k->purchase->profit)[0], 'weight' => $wei2];
                // dd($obj2);
                if (!empty($purchase)) {
                    foreach ($purchase as $ky => $v) {
                        if ($purchase[$ky]['code_number'] == $k->purchase->code_number) {
                            $purchase[$ky]['qty']++;
                        }
                    }
                    array_push($purchase, $obj2);
                } else {
                    array_push($purchase, $obj2);
                }
            }
        }
        if ($request->type == 4 || $request->type == 1) {
            if ($request->start && $request->end) {
                $ptoday_income = PosPlatinumSale::where('shop_owner_id', $this->getshopid())->whereBetween('date', [$request->start, $request->end])->get();
            } else {
                $ptoday_income = PosPlatinumSale::where('shop_owner_id', $this->getshopid())->get();
            }
            foreach ($ptoday_income as $p) {
                $subtotal += explode('/', $p->purchase->profit)[0];
                $qty++;
                $wei3 = $p->purchase->product_gram . 'g';
                $obj3 = ['name' => $p->purchase->platinum_name, 'code_number' => $p->purchase->code_number, 'qty' => 1, 'fee' => explode('/', $p->purchase->profit)[0], 'weight' => $wei3];
                // dd($obj1);
                if (!empty($purchase)) {
                    foreach ($purchase as $k => $v) {
                        if ($purchase[$k]['code_number'] == $p->purchase->code_number) {
                            $purchase[$k]['qty']++;
                        }
                    }
                    array_push($purchase, $obj3);
                } else {
                    array_push($purchase, $obj3);
                }
            }
        }
        if ($request->type == 5 || $request->type == 1) {
            if ($request->start && $request->end) {
                $wtoday_income = PosWhiteGoldSale::where('shop_owner_id', $this->getshopid())->whereBetween('date', [$request->start, $request->end])->get();
            } else {
                $wtoday_income = PosWhiteGoldSale::where('shop_owner_id', $this->getshopid())->get();
            }
            foreach ($wtoday_income as $w) {
                $subtotal += explode('/', $w->purchase->profit)[0];
                $qty++;
                $wei4 = $w->purchase->product_gram . 'g';
                $obj4 = ['name' => $w->purchase->whitegold_name, 'code_number' => $w->purchase->code_number, 'qty' => 1, 'fee' => explode('/', $w->purchase->profit)[0], 'weight' => $wei4];
                // dd($obj1);
                if (!empty($purchase)) {
                    foreach ($purchase as $k => $v) {
                        if ($purchase[$k]['code_number'] == $w->purchase->code_number) {
                            $purchase[$k]['qty']++;
                        }
                    }
                    array_push($purchase, $obj4);
                } else {
                    array_push($purchase, $obj4);
                }
            }
        }

        return response()->json(['total' => $subtotal, 'qty' => $qty, 'purchases' => $purchase]);
    }

    //Stock List
    public function get_stock_lists()
    {
        $shopowner = ShopOwner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPurchase::where('shop_owner_id', $this->getshopid())->get();
        $kyoutpurchases = PosKyoutPurchase::where('shop_owner_id', $this->getshopid())->get();
        $platinumpurchases = PosPlatinumPurchase::where('shop_owner_id', $this->getshopid())->get();
        $whitegoldpurchases = PosWhiteGoldPurchase::where('shop_owner_id', $this->getshopid())->get();
        $qty = 0;
        foreach ($purchases as $g) {
            $qty += $g->stock_qty;
        }
        foreach ($kyoutpurchases as $k) {
            $qty += $k->stock_qty;
        }
        foreach ($platinumpurchases as $p) {
            $qty += $p->stock_qty;
        }
        foreach ($whitegoldpurchases as $w) {
            $qty += $w->stock_qty;
        }
        return view('backend.pos.stock_lists', ['shopowner' => $shopowner, 'purchases' => $purchases, 'kyoutpurchases' => $kyoutpurchases, 'platinumpurchases' => $platinumpurchases, 'whitegoldpurchases' => $whitegoldpurchases, 'tot_qty' => $qty]);
    }
    public function tab_stock_lists(Request $request)
    {
        $qty = 0;
        $purchase = [];
        if ($request->type == 2 || $request->type == 1) {
            if ($request->start && $request->end) {
                $purchases1 = PosPurchase::where('shop_owner_id', $this->getshopid())->whereBetween('date', [$request->start, $request->end])->get();
            } else {
                $purchases1 = PosPurchase::where('shop_owner_id', $this->getshopid())->get();
            }
            foreach ($purchases1 as $g) {
                $qty += $g->stock_qty;
                $wei1 = '';
                $weight1 = explode('/', $g->product_gram_kyat_pe_yway);
                if ($weight1[1] != 0 || $weight1[1] != '') {
                    $wei1 .= $weight1[1] . 'ကျပ်';
                }
                if ($weight1[2] != 0 || $weight1[2] != '') {
                    $wei1 .= $weight1[2] . 'ပဲ';
                }
                if ($weight1[3] != 0 || $weight1[3] != '') {
                    $wei1 .= $weight1[3] . 'ရွေး';
                }
                $obj1 = ['name' => $g->gold_name, 'code_number' => $g->code_number, 'qty' => $g->stock_qty, 'fee' => $g->gold_fee, 'weight' => $wei1, 'date' => $g->date];
                array_push($purchase, $obj1);
            }
        }
        if ($request->type == 3 || $request->type == 1) {
            if ($request->start && $request->end) {
                $purchases2 = PosKyoutPurchase::where('shop_owner_id', $this->getshopid())->whereBetween('date', [$request->start, $request->end])->get();
            } else {
                $purchases2 = PosKyoutPurchase::where('shop_owner_id', $this->getshopid())->get();
            }
            foreach ($purchases2 as $k) {
                $qty += $k->stock_qty;
                $wei2 = '';
                $weight2 = explode('/', $k->gold_gram_kyat_pe_yway);
                if ($weight2[1] != 0 || $weight2[1] != '') {
                    $wei2 .= $weight2[1] . 'ကျပ်';
                }
                if ($weight2[2] != 0 || $weight2[2] != '') {
                    $wei2 .= $weight2[2] . 'ပဲ';
                }
                if ($weight2[3] != 0 || $weight2[3] != '') {
                    $wei2 .= $weight2[3] . 'ရွေး';
                }
                $obj2 = ['name' => $k->gold_name, 'code_number' => $k->code_number, 'qty' => $k->stock_qty, 'fee' => $k->gold_fee, 'weight' => $wei2, 'date' => $k->date];
                array_push($purchase, $obj2);
            }
        }
        if ($request->type == 4 || $request->type == 1) {
            if ($request->start && $request->end) {
                $purchases3 = PosPlatinumPurchase::where('shop_owner_id', $this->getshopid())->whereBetween('date', [$request->start, $request->end])->get();
            } else {
                $purchases3 = PosPlatinumPurchase::where('shop_owner_id', $this->getshopid())->get();
            }
            foreach ($purchases3 as $p) {
                $qty += $p->stock_qty;
                $wei3 = $p->product_gram . 'g';
                $obj3 = ['name' => $p->platinum_name, 'code_number' => $p->code_number, 'qty' => $p->stock_qty, 'fee' => $p->gold_fee, 'weight' => $wei3, 'date' => $p->date];
                array_push($purchase, $obj3);
            }
        }
        if ($request->type == 5 || $request->type == 1) {
            if ($request->start && $request->end) {
                $purchases4 = PosWhiteGoldPurchase::where('shop_owner_id', $this->getshopid())->whereBetween('date', [$request->start, $request->end])->get();
            } else {
                $purchases4 = PosWhiteGoldPurchase::where('shop_owner_id', $this->getshopid())->get();
            }
            foreach ($purchases4 as $w) {
                $qty += $w->stock_qty;
                $wei4 = $p->product_gram . 'g';
                $obj4 = ['name' => $p->whitegold_name, 'code_number' => $p->code_number, 'qty' => $p->stock_qty, 'fee' => $p->gold_fee, 'weight' => $wei4, 'date' => $p->date];
                array_push($purchase, $obj4);
            }
        }
        return response()->json([
            'purchases' => $purchase,
            'qty' => $qty]);
    }

    //Shop Profile
    public function get_shop_profile()
    {
        $users_list = $this->getuserlistbyrolelevel();
        $result = ShopOwner::where('id', $this->getshopid())->with(['getPhotos'])->orderBy('created_at', 'desc')->get();
        $items = Item::where('shop_id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        return view('backend.pos.shop_profile', ['shopowner' => $result, 'items' => $items, 'managers' => $users_list]);
    }
    public function get_shop_edit()
    {
        if ($this->isstaff()) {
            return $this->unauthorize();
        }
        $shopowner = ShopOwner::where('id', $this->getshopid())->with(['getPhotos'])->orderBy('created_at', 'desc')->get();
        return view('backend.pos.shop_edit', ['shopowner' => $shopowner]);
    }

    public function shop_update(Request $request, $id)
    {
        if ($this->isstaff()) {
            return $this->unauthorize();
        }
        //remove token and method from request
        $input = $request->except('_token', '_method');

        // $input = $request->except('_token', '_method');
        $shopowner = ShopOwner::findOrFail($id);
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'shop_name' => ['required', 'string', 'max:255'], //Rule::unique('shop_owners')->ignore($shopowner->id)
                'shop_name_url' => ['required', 'alpha_num', 'string', 'max:255'],
                'description' => ['string', 'max:1112255'],
                'shop_logo' => 'nullable|mimes:jpeg,bmp,png,jpg',
                'banner.*' => 'mimes:jpeg,bmp,png,jpg',
                // 'main_phone' =>  ['required', 'string', 'max:20','unique:manager,phone','unique:users,phone','unique:shop_owners,main_phone'],
                'main_phone' => [
                    'required',
                    Rule::unique('shop_owners')->ignore($shopowner->id),
                    Rule::unique('manager', 'phone')->ignore($shopowner->id),
                ],
                'messenger_link' => 'max:1130',
            ]
        );
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
        // dd($add_ph_array);
        $shopowner->name = $request->name;
        $shopowner->shop_name_url = $request->shop_name_url;
        $shopowner->shop_name = $request->shop_name;
        $shopowner->shop_name_myan = $request->shop_name_myan;
        $shopowner->description = $request->description;
        $shopowner->address = $request->address;
        $shopowner->main_phone = $request->main_phone;
        $shopowner->valuable_product = $request->valuable_product;
        $shopowner->undamaged_product = $request->undamaged_product;
        $shopowner->damaged_product = $request->damaged_product;
        $shopowner->messenger_link = $request->messenger_link;
        $shopowner->page_link = $request->page_link;
        $shopowner->map = $request->map;
        $shopowner->additional_phones = json_encode($add_ph_array);
        $shopowner->other_address = $request->other_address;

        if ($request->file('shop_logo')) {
            if (File::exists(public_path($shopowner->shop_logo))) {
                File::delete(public_path($shopowner->shop_logo));
            }
            $shop_logo = time() . '1.' . $request->file('shop_logo')->getClientOriginalExtension();
            $get_path = $request->file('shop_logo')->move(public_path('images/logo'), $shop_logo);
            $this->setthumbslogo($get_path, $shop_logo);
            $shopowner->shop_logo = $shop_logo;
        }
        $updateSuccess = $shopowner->update();
        if ($request->hasFile('banner')) {
            $shop_banner = ShopBanner::where('shop_owner_id', $id)->get();
            foreach ($shop_banner as $b) {
                if (File::exists(public_path($b->location))) {
                    File::delete(public_path($b->location));
                }
            }
            if (isset($shopowner->getPhotos)) {
                $del = $shopowner->getPhotos->pluck("id");
                ShopBanner::destroy($del);
            }
            $fileNameArr = [];
            foreach ($request->banner as $b) {
                $newFileName = uniqid() . '_banner' . '.' . $b->getClientOriginalExtension();
                array_push($fileNameArr, $newFileName);
                $b->move(public_path('images/banner'), $newFileName);
            }
            foreach ($fileNameArr as $f) {
                $banner = new ShopBanner();
                $banner->shop_owner_id = $id;
                $banner->location = $f;
                $banner->save();
            }
        }
        if ($updateSuccess) {
            return redirect()->route('backside.shop_owner.pos.shop_profile')->with(['status' => 'success', 'message' => 'Your Shop was successfully Edited']);
        } else {
            return dd($input);
        }
    }
    public function get_password()
    {
        return view('backend.pos.changePassword');
    }
    public function change_password(Request $request)
    {
        // return dd($request);
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
        ]);

        return redirect('backside/shop_owner/pos-update-password');
    }
    public function edit_password()
    {
        return view('backend.pos.editPassword');
    }
    public function store_new_password(Request $request)
    {
        // return dd($request);
        $request->validate([
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        ShopOwner::where('id', Auth::guard('shop_owner')->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('backside.shop_owner.pos.shop_profile')->with(['status' => 'success', 'message' => 'Your Shop Password was successfully Updated']);
    }

}
