<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\VisitorLogActivity;
use App\Models\BuyNowClickLog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function login(Request $request)
    {

        $data = $request->except('_token');



        $validator= Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();

        }

        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            return redirect(RouteServiceProvider::HOME);
        }else{
            return 'fail';
        }

    }
    public function logout(Request $request)
    {
        //custom code by yk
        $guest=Session::get('guest_id');
        //custom code by yk

        $user = Auth::User();




        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {

            Session::put('guest_id',$guest);
            return $response;
        }

        //custom code by yk
        Session::put('guest_id',$guest);
        //custom code by yk


        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = url()->previous();
    }
}
