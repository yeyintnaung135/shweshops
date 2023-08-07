<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Superadmin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class SuperadminRegisterController extends Controller
{
    //
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest:super_admin');
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:super_admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create()
    {
        return view('auth.super_admin_register');
    }

    protected function store(Request $request)
    {
        $valid=$this->validator($request->except('_token'));
        if( $valid->fails())
        {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->except("_token");
        $super_admin_data = Superadmin::create([
            'name' => $data['name'],
            'role' => "2",
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => 'yes'
        ]);

        Auth::guard('super_admin')->logout();
        return redirect()->route('backside.super_admin.login')->with('message',"Admin ဘက်က approve လုပ်တာ စောင့်ပေးပါ");

    }

}
