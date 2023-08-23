<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\Logs\SuperAdminLogActivityTrait;
use App\Http\Controllers\Trait\YkImage;
use App\Models\PercentTemplate;
use App\Models\PremiumTemplate;
use App\Models\ShopBanner;
use App\Models\Shopdirectory;
use App\Models\Shops;
use App\Models\State;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ShopownerRegisterController extends Controller
{

    use RegistersUsers, YkImage, SuperAdminLogActivityTrait;

    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function activity_index()
    {
        $shopowner = Shops::all();
        return view('backend.super_admin.activity_logs.shops', ['shopowner' => $shopowner]);
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'shop_name_url' => ['required', 'alpha_num', 'string', 'max:50', 'unique:shop_owners'],
            'shop_logo' => ['required', 'mimes:jpeg,bmp,png,jpg'],
            'banner.*' => 'mimes:jpeg,bmp,png,jpg',
            'email' => ['required', 'string', 'email', 'max:50', 'unique:shop_owners'],
            'password' => ['required', 'string', 'max:6', 'confirmed'],
            'shop_name' => ['required', 'string', 'max:50', 'unique:shop_owners,shop_name'],
            'main_phone' => ['required', 'string', 'max:11', 'unique:manager,phone', 'unique:users,phone', 'unique:shop_owners,main_phone'],
            'description' => ['string', 'max:1255555'],
            'page_link' => ['required', 'string', 'max:1111'],
            // 'undamaged_product' => ['numeric'],
            // 'valuable_product' => [ 'numeric'],
            // 'damaged_product' => ['numeric'],
            'undamaged_product' => ['string', 'max:50'],
            'valuable_product' => ['string', 'max:50'],
            'damaged_product' => ['string', 'max:50'],
            'state' => ['required'],
            'township' => ['required'],
            'premium' => ['sometimes', 'required', 'string', 'in:yes,no'],
            'premium_template_id' => 'sometimes|required|exists:premium_templates,id',
        ]);
    }

    protected function create()
    {
        $states = State::get();
        $premium_templates = PremiumTemplate::get();
        return view('backend.super_admin.shops.create', ['states' => $states, 'premium_templates' => $premium_templates]);
    }

    protected function store(Request $request)
    {
        if ($request->premium == 'yes') {
            if (!$request->hasFile('banner')) {
                return redirect()->back()->withErrors(['banner.*' => 'File Required'])->withInput();
            }
        }

        $valid = $this->validator($request->except('_token'));
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
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
        $this->setthumbslogo($lpath, $imageNameone);

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
        $shopdata = Shops::create($data);

        foreach ($fileNameArr as $f) {
            $banner = new ShopBanner();
            $banner->shop_owner_id = $shopdata->id;
            $banner->location = $f;
            $banner->save();
        }

        $this->SuperadminShopCreateLog($shopdata);

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

            PercentTemplate::create($template_percent);

            $shop_dir['shop_id'] = $shop_id;
            ShopDirectory::updateOrCreate($shop_dir);

            Session::flash('message', 'Your Shop was successfully created');

            return redirect()->route('shops.all');
        } else {
            return 'false';
        }
    }

    public function edit($id)
    {
        $states = State::get();
        $shopowner = Shops::findOrFail($id);
        $premium_templates = PremiumTemplate::get();
        return view('backend.super_admin.shops.edit', ['shopowner' => $shopowner, 'states' => $states, 'premium_templates' => $premium_templates]);
    }

    public function update(Request $request, $id)
    {
        $input = $request->except('_token', '_method');
        $shopowner = Shops::findOrFail($id);
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
                'premium' => ['sometimes', 'required', 'string', 'in:yes,no'],
                'premium_template_id' => 'sometimes|required|exists:premium_templates,id',
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
        $shopowner->premium_template_id = $request->premium_template_id;
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
            $this->SuperadminShopEditLog($input);
            // Session::flash('message', 'Your ads was successfully updated');

            return redirect()->route('shops.all');
        }
    }
}
