<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ShopOwnerLoginController extends Controller
{
    //use default auth class
    use AuthenticatesUsers;

    //    for redirect to dashboard if loginned
    public function __construct()
    {
        //tz
        $this->middleware('guest:shop_owners_and_staffs')->except('logout');
        $this->middleware('guest')->except('logout');
    }
    //    for redirect to dashboard if loginned

    //    show form
    public function loginform($from = null)
    {
//        return $from;
        return view('auth.shop_owner_login', ['from' => $from]);
    }

    public function pos_login_form($from = null)
    {
//        return $from;
        $role = Role::all();
        return view('auth.pos_login', ['from' => $from, 'role' => $role]);
    }
    //    show form

    //if user emial and password is correct loginned
    public function login(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, [
            "value" => 'required|regex:/(^09([0-9]+)(\d+)?$)/u|min:5|max:11',
            "password" => "required|max:100",
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Something wrong!!');

        }

        $roleCheck = Auth::guard('shop_owners_and_staffs')->attempt(['phone' => $request->value, 'password' => $request->password, 'deleted_at' => null]);
        if ($roleCheck) {
            // if(Auth::guard('shop_owners_and_staffs')->user()->pos_only == 'yes'){
            //     return redirect()->route('backside.shop_owner.pos.dashboard');
            // }
            Session::flash('loginedSO', 'shopownerlogined');
            if ($request->fromsupport == 'support') {
                return redirect(route('backside.shop_owner.support'));
            } else {
                return redirect()->route('backside.shop_owner.detail');
            }
        } else {

            return redirect()->back()->with('error', 'Phone or password is invalid');
        }

    }

    public function pos_login(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, [
            "value" => 'required|regex:/(^09([0-9]+)(\d+)?$)/u|min:5|max:11',
            "password" => "required|max:100",
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Something wrong!!');

        }

        $roleCheck = Auth::guard('shop_owners_and_staffs')->attempt(['phone' => $request->value, 'password' => $request->password, 'role_id' => $request->role_id, 'deleted_at' => null]);
        if ($roleCheck) {
            Session::put('staff_role', $request->role_id);
            Session::flash('loginedSO', 'shopownerlogined');
            if ($request->from == 'fromhelpandsupport') {
                return redirect(url('backside/shop_owner/support'));
            } else {
                return redirect()->route('backside.shop_owner.pos.dashboard');
            }
        } else {
            return redirect()->back()->with('error', 'Phone or password is invalid');
        }
    }

    //logout function
    public function logout(Request $request)
    {
        //custom code by yk
        $guest = Session::get('guest_id');

        // Check which guard to use based on the logged-in user
        if (Auth::guard('shop_owners_and_staffs')->check()) {
            Auth::guard('shop_owners_and_staffs')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        } else {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }

        // Restore guest session and redirect to home
        Session::put('guest_id', $guest);
        return redirect(RouteServiceProvider::HOME);
    }
}
