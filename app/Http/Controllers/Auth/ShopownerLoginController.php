<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Shopowner;
use App\Models\Shopdirectory;
use App\Models\ShopBanner;
use App\Models\Percent_template;

class ShopownerLoginController extends Controller
{
    //use default auth class
    use AuthenticatesUsers;

    //    for redirect to dashboard if loginned
    public function __construct()
    {
        //tz
        $this->middleware('guest:shop_owner')->except('logout');
        $this->middleware('guest:shop_role')->except('logout');
        $this->middleware('guest')->except('logout');
    }
    //    for redirect to dashboard if loginned

    //    show form
    public function loginform($from=null)
    {
//        return $from;
        return view('auth.shop_owner_login',['from'=>$from]);
    }

    public function pos_login_form($from=null)
    {
//        return $from;
        $role = Role::all();
        return view('auth.pos_login',['from'=>$from,'role'=>$role]);
    }
    //    show form

    //if user emial and password is correct loginned
    public function login(Request $request)
    {
        $data = $request->except('_token');
        $validator= Validator::make($data, [
            "value" => 'required|regex:/(^09([0-9]+)(\d+)?$)/u|min:5|max:11',
            "password" => "required",
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error', 'Something wrong!!');

        }

        $ownerCheck = Auth::guard('shop_owner')->attempt(['main_phone' => $request->value, 'password' => $request->password]);
        $roleCheck = Auth::guard('shop_role')->attempt(['phone' => $request->value, 'password' => $request->password, 'deleted_at' => null]);
            if ($roleCheck || $ownerCheck) {
                // if(Auth::guard('shop_owner')->user()->pos_only == 'yes'){
                //     return redirect()->route('backside.shop_owner.pos.dashboard');
                // }
                Session::flash('loginedSO','shopownerlogined');
                if($request->fromsupport == 'support'){
                    return redirect(url('backside/shop_owner/support'));
                }
                else{
                    return redirect()->route('backside.shop_owner.detail');
                }
            }
            else {

                 return redirect()->back()->with('error', 'Phone or password is invalid');
            }

    }

    public function pos_login(Request $request)
    {
        $data = $request->except('_token');
        $validator= Validator::make($data, [
            "value" => 'required|regex:/(^09([0-9]+)(\d+)?$)/u|min:5|max:11',
            "password" => "required",
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error', 'Something wrong!!');

        }
        $ownerCheck = Auth::guard('shop_owner')->attempt(['main_phone' => $request->value, 'password' => $request->password]);
        $roleCheck = Auth::guard('shop_role')->attempt(['phone' => $request->value, 'password' => $request->password, 'deleted_at' => null]);
            if ($roleCheck || $ownerCheck) {
                Session::flash('loginedSO','shopownerlogined');
                if($request->from == 'fromhelpandsupport'){
                    return redirect(url('backside/shop_owner/support'));
                }
                else if($request->role_id == 4){
                    return redirect()->route('backside.shop_owner.pos.dashboard');
                }
                else{
                    Auth::logout();
                    Session::flush();
                    return redirect()->back()->with('error', 'Need to choose right role!');
                }
            }
            else {
                $staff = DB::table('pos_staffs')->where('phone',$request->value)->where('role_id',$request->role_id)->first();
                if ($staff && Hash::check($request->password, $staff->password)) {
                $shop = Shopowner::where('id',$staff->shop_id)->first();
                $ownerCheck = Auth::guard('shop_owner')->attempt(['main_phone' => $shop->main_phone, 'password' => $request->password]);
                $roleCheck = Auth::guard('shop_role')->attempt(['phone' => $shop->main_phone, 'password' => $request->password, 'deleted_at' => null]);
                if ($roleCheck || $ownerCheck) {
                    Session::put('staff_role',$request->role_id);
                    Session::flash('loginedSO','shopownerlogined');
                    return redirect()->route('backside.shop_owner.pos.dashboard');
                } 
                }else{
                 return redirect()->back()->with('error', 'Phone or password is invalid');
                }
            }
    }

    //logout function
    public function logout(Request $request)
    {

        //custom code by yk
        $guest=Session::get('guest_id');
        //custom code by yk

        $username =  auth()->check() ? auth()->user()->username : 0;
        if (isset(Auth::guard('shop_role')->user()->id)) {

            Auth::guard('shop_role')->logout();
            return redirect(RouteServiceProvider::HOME);

        } else if (isset(Auth::guard('web')->user()->id)) {

            Auth::guard('web')->logout();


            return redirect()->back();

        } else {
            Auth::guard('shop_owner')->logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();

        }

         //custom code by yk
         Session::put('guest_id',$guest);
         //custom code by yk
        return redirect(RouteServiceProvider::HOME);
    }
}
