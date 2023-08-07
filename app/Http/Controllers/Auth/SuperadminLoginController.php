<?php

namespace App\Http\Controllers\Auth;

use App\Superadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SuperadminLoginController extends Controller
{
    //use default auth class
    use AuthenticatesUsers;

    //    for redirect to dashboard if loginned
    public function __construct()
    {
        $this->middleware('guest:super_admin')->except('logout');
    }
    //    for redirect to dashboard if loginned

    //    show form
    public function loginform(Request $request)
    {
        return view('auth.super_admin_login');
    }
    //    show form

    //if user emial and password is correct loginned
    public function login(Request $request)
    {
        
        $data = $request->except('_token');
        $validator= Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();

        }

        if(Auth::guard('super_admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            
             if(Auth::guard('super_admin')->check()){
                if( Auth::guard('super_admin')->user()->role == 0 || Auth::guard('super_admin')->user()->role == 1 || Auth::guard('super_admin')->user()->role == 4){
                    return redirect(RouteServiceProvider::SUPERADMIN); 
                }else{
                    return redirect()->back()->with('message','Login Fail');
                }
             }
        }else{
            return redirect()->back()->with('message','Login Fail');
        }

    }
    //if user emial and password is correct loginned

    public function logout(Request $request) {

        //custom code by yk
        $guest=Session::get('guest_id');
        //custom code by yk
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
        Auth::guard('super_admin')->logout();
             //custom code by yk
             Session::put('guest_id',$guest);
             //custom code by yk
        return redirect(RouteServiceProvider::HOME);
    }
      

}