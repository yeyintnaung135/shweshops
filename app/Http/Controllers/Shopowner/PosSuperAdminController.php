<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Models\CountSetting;
use App\Models\FeaturesForShops;
use App\Models\PosSuperAdmin;
use App\Models\ShopBanner;
use App\Models\ShopDirectory;
use App\Models\ShopOwner;
use App\Models\State;
use App\Models\Township;
use App\Providers\RouteServiceProvider;
use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PosSuperAdminController extends Controller
{
    //use default auth class
    use AuthenticatesUsers;
    public function login_form(Request $request): View
    {
        return view('auth.pos_super_admin_login');
    }

    //if user emial and password is correct loginned
    public function login(Request $request): mixed
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::guard('pos_super_admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            if (Auth::guard('pos_super_admin')->check()) {
                return redirect()->route('backside.pos_super_admin.dashboard');
            }
        } else {
            return redirect()->back()->with('message', 'Login Fail');
        }
    }
    //if user emial and password is correct loginned
    public function logout(Request $request): RedirectResponse
    {
        //custom code by yk
        $guest = Session::get('guest_id');
        //custom code by yk
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        Auth::guard('pos_super_admin')->logout();
        //custom code by yk
        Session::put('guest_id', $guest);
        //custom code by yk
        return redirect(RouteServiceProvider::HOME);
    }
    //end auth

    //Shops
    public function all(): View
    {
        $shopowner = ShopOwner::all();
        // dd($shopowner);
        $features = FeaturesForShops::all();
        return view('backend.pos_super_admin.shops.all', ['shopowner' => $shopowner, 'features' => $features]);
    }
    public function get_all_shops(Request $request): JsonResponse
    {
        $searchByFromdate = $request->start;
        $searchByTodate = $request->end;

        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }
        $shopowner = ShopOwner::whereDate('created_at', '<=', $searchByFromdate)
            ->whereDate('created_at', '>=', $searchByTodate)
            ->get();

        $features = FeaturesForShops::all();
        return response()->json([
            'shopowner' => $shopowner,
            'features' => $features,
        ]);
    }
    protected function shop_create(): View
    {
        $states = State::get();
        return view('backend.pos_super_admin.shops.create', ['states' => $states]);
    }

    //getTownship
    public function get_township(Request $request): JsonResponse
    {
        if (is_array($request->id)) {
            $townships = Township::select('id', 'name', 'myan_name')->whereIn('state_id', $request->id)->get();
        } else {
            $townships = Township::select('id', 'name', 'myan_name')->where('state_id', $request->id)->get();
        }
        return response()->json($townships);
    }
    protected function shop_store(Request $request): RedirectResponse
    {
        if ($request->premium == 'yes') {
            if (!$request->hasFile('banner')) {
                return redirect()->back()->withErrors(['banner.*' => 'File Required'])->withInput();
            }
        }

        $fileNameArr = [];
        if ($request->hasFile('banner')) {
            foreach ($request->banner as $b) {

                $newFileName = uniqid() . '_banner' . '.' . $b->getClientOriginalExtension();
                array_push($fileNameArr, $newFileName);
                $bpath = $b->move(public_path('images/banner/'), $newFileName);
            }
        }

        $data = $request->except("_token");

        $shop_logo = $data['shop_logo'];
        //   $shop_banner = $data['shop_banner'];

        //file upload
        $imageNameone = time() . 'logo' . '.' . $shop_logo->getClientOriginalExtension();

        $lpath = $shop_logo->move(public_path('images/logo/'), $imageNameone);
        //   $this->setthumbslogo($lpath, $imageNameone);

        //store database
        $filepath_logo = $imageNameone;
        //   $filepath_banner = $imageNametwo;
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

        //data insert
        $data['shop_logo'] = $filepath_logo;
        $data['active'] = 'yes';
        $withouthashpsw = $data['password'];

        $data['password'] = Hash::make($data['password']);
        $data['additional_phones'] = json_encode($add_ph_array);
        // $data['state']=$request->state;
        // $data['township']=$request->township;
        $shopdata = ShopOwner::create($data);
        $shopdata->pos_only = 'yes';
        $shopdata->save();

        foreach ($fileNameArr as $f) {
            $banner = new ShopBanner();
            $banner->shop_owner_id = $shopdata->id;
            $banner->location = $f;
            $banner->save();
        }

        // \SuperadminLogActivity::SuperadminShopCreateLog($shopdata);

        if ($shopdata) {
            $shop_id = $shopdata->id;
            $template_percent = [
                'shop_id' => $shop_id,
                'name' => 'default',
                'handmade' => 1,
                'charge' => 1,
                'undamaged_product' => $data['undamaged_product'],
                'damaged_product' => $data['damaged_product'],
                'valuable_product' => $data['valuable_product'],
            ];

            Percent_template::create($template_percent);

            $shop_dir['shop_id'] = $shop_id;
            ShopDirectory::updateOrCreate($shop_dir);

            FeaturesForShops::create(['shop_id' => $shopdata->id, 'feature' => 'pos_only']);

            Session::flash('message', 'Your Shop was successfully created');

            return redirect()->route('pos_super_admin_shops.all');
        } else {
            return 'false';
        }
    }
    public function shop_edit($id): View
    {
        $states = State::get();
        $shopowner = ShopOwner::findOrFail($id);
        return view('backend.pos_super_admin.shops.edit', ['shopowner' => $shopowner, 'states' => $states]);
    }
    public function shop_update(Request $request, $id)
    {
        $input = $request->except('_token', '_method');
        $shopowner = ShopOwner::findOrFail($id);
//        return $shopowner;
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'shop_name' => ['required', 'string', 'max:255'],
                'shop_name_url' => ['required', 'alpha_num', 'string', 'max:255'],
                'description' => ['string', 'max:1255555'],
                'shop_logo' => 'nullable|mimes:jpeg,bmp,png,jpg',
                'banner.*' => 'nullable|mimes:jpeg,bmp,png,jpg',
                // 'main_phone' =>  ['required', 'string', 'max:20','unique:manager,phone','unique:users,phone','unique:shop_owners,main_phone'],
                'main_phone' => [
                    'required',
                    Rule::unique('shop_owners')->ignore($shopowner->id),
                    Rule::unique('manager', 'phone')->ignore($shopowner->id),
                ],
                'messenger_link' => 'max:1130',
                'state' => ['required'],
//                'township' => ['required']
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
        $shopowner->name = $request->name;
        $shopowner->shop_name_url = $request->shop_name_url;
        $shopowner->shop_name = $request->shop_name;
        $shopowner->shop_name_myan = $request->shop_name_myan;
        $shopowner->description = $request->description;
        $shopowner->address = $request->address;
        $shopowner->main_phone = $request->main_phone;
        $shopowner->premium = $request->premium;
        $shopowner->valuable_product = $request->undamaged_product;
        $shopowner->undamaged_product = $request->valuable_product;
        $shopowner->damaged_product = $request->damaged_product;
        $shopowner->messenger_link = $request->messenger_linkt;
        $shopowner->page_link = $request->page_link;
        $shopowner->map = $request->map;
        $shopowner->additional_phones = json_encode($add_ph_array);
        $shopowner->state = $request->state;
        $shopowner->township = $request->township;
        $shopowner->other_address = $request->other_address;
        if ($request->file('shop_logo')) {
            if (File::exists(public_path('images/logo/' . $shopowner->shop_logo))) {
                File::delete(public_path('images/logo/' . $shopowner->shop_logo));
            }

            $shop_logo = time() . '1.' . $request->file('shop_logo')->getClientOriginalExtension();
            $get_path = $request->file('shop_logo')->move(public_path('images/logo/'), $shop_logo);
            $this->setthumbslogo($get_path, $shop_logo);

            $shopowner->shop_logo = $shop_logo;

        }

        $updateSuccess = $shopowner->update();

        $shop_dir['shop_id'] = $id;
        ShopDirectory::updateOrCreate($shop_dir);

        if ($request->hasFile('banner')) {
            $shop_banner = ShopBanner::where('shop_owner_id', $id)->get();
            foreach ($shop_banner as $b) {
                if (File::exists(public_path('images/banner/' . $b->location))) {
                    File::delete(public_path('images/banner/' . $b->location));
                }
            }
            if (isset($shopowner->getPhotos)) {
                $del = $shopowner->getPhotos->pluck("id");
                ShopBanner::destroy($del);
            }

            //File Restore
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
            // \SuperadminLogActivity::SuperadminShopEditLog($input);
            // Session::flash('message', 'Your ads was successfully updated');
            return redirect()->route('pos_super_admin_shops.all');
        }
    }
    public function shop_trash($id): RedirectResponse
    {
        // dd($id);
        $shop_owner = ShopOwner::findOrFail($id);
        if (isset($shop_owner->getPhotos)) {
            $del = $shop_owner->getPhotos->pluck("id");
            ShopBanner::destroy($del);
        }
        $shop_owner->delete();
        return redirect()->route('pos_super_admin_shops.all')->with(['status' => 'success', 'message' => 'Your Shop was successfully Deleted']);
    }
    public function shop_show($id): View
    {
        $shop = ShopOwner::findOrFail($id);
        $all = CountSetting::where('shop_id', $shop->id)->where('name', 'all')->get();
        $products_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'item')->get();
        $users_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'users')->get();
        $users_inquiry_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'inquiry')->get();
        $shops_view_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'shop_view')->get();
        $items_view_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'items_view')->get();
        $unique_product_click_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'item_unique_view')->get();
        $buy_now_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'buyNowClick')->get();
        $addtocartclick_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'addToCartClick')->get();
        $whislistclick_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'whislistclick')->get();
        $discountview_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'discountview')->get();
        $adsview_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'adsview')->get();
        $poson = FeaturesForShops::where([['shop_id', '=', $shop->id], ['feature', '=', 'pos']])->get();
        return view('backend.pos_super_admin.shops.detail', [
            'all' => $all,
            'shop' => $shop,
            'products_count_setting' => $products_count_setting,
            'users_count_setting' => $users_count_setting,
            'users_inquiry_setting' => $users_inquiry_setting,
            'shops_view_count_setting' => $shops_view_count_setting,
            'items_view_count_setting' => $items_view_count_setting,
            'unique_product_click_count_setting' => $unique_product_click_count_setting,
            'buy_now_count_setting' => $buy_now_count_setting,
            'addtocartclick_count_setting' => $addtocartclick_count_setting,
            'whislistclick_count_setting' => $whislistclick_count_setting,
            'discountview_count_setting' => $discountview_count_setting,
            'adsview_count_setting' => $adsview_count_setting,
            'poson' => $poson,
        ]);
    }
    //End Shops

    //Admins
    public function list(): View
    {
        $super_admin = PosSuperAdmin::all();
        return view('backend.pos_super_admin.list', ['super_admin' => $super_admin]);
    }
    public function create(): View
    {
        return view('backend.pos_super_admin.create');
    }
    public function store(Request $request): RedirectResponse
    {

        $data = $request->except('_token');
        $valid = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->except("_token");
        $super_admin_data = PosSuperAdmin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => 'yes',
        ]);

        return redirect()->route('pos_super_admin_role.list')->with(['status' => 'success', 'message' => 'Sub Admin was successfully created']);
    }
    public function edit($id): View
    {

        $super_admin = PosSuperAdmin::findOrFail($id);
        return view('backend.pos_super_admin.edit', ['super_admin' => $super_admin]);

    }
    public function update(Request $request, $id): RedirectResponse
    {

        $admin = PosSuperAdmin::findOrFail($id);

        if ($request->current_password || $request->new_password || $request->new_confirm_password) {

            $request->validate([
                'current_password' => ['required', 'min:8', new MatchOldPassword],

                'new_password' => ['required', 'min:8'],

                'new_confirm_password' => ['same:new_password'],
            ]);
            $admin->password = Hash::make($request->new_password);
        } else {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
            ]);
        }

        $input = $request->except('_token', '_method');

        $admin->name = $request->name;
        $admin->email = $request->email;
        $result = $admin->update();

        if ($result) {

            Session::flash('message', 'Your admin was successfully updated');
            return redirect()->route('pos_super_admin_role.list');
        }
    }
    public function delete(Request $request, $id): RedirectResponse
    {
        PosSuperAdmin::find($id)->delete();
        return redirect()->route('pos_super_admin_role.list')->with(['status' => 'success', 'message' => 'Sub Admin was successfully deleted']);
    }
    //end admins

    public function get_dashboard(): View
    {
        return view('backend.pos_super_admin.dashboard');
    }
}
