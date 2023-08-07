<?php

namespace App\Http\Controllers\Auth;

use App\Mail\YkpswresetMail;
use App\Passwordresetforshop;
use App\Rules\Ykcheckexist;
use App\Shopowner;
use App\ShopRole;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use MongoDB\Driver\Session;

class YkforgotpasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        if(Str::contains(url()->current(),'shop_owner')) {
            return view('auth.passwords.email');

        }else{
              return response()->json('showpasswordreset');
        }
    }

    public function send_reset_code_form(Request $request)
    {

        $input = $request->except('_token');

        //temporary

        $rules = [
//                'emailorphone' => ['required', 'min:5', 'max:13', new Ykcheckexist]
            'emailorphone' => ['required', 'digits_between:5,13', new Ykcheckexist]

        ];
        $message = [
            'emailorphone.required' => 'Email Or Phone Required',
            'emailorphone.digits_between' => 'Wrong Phone number',
//            'emailorphone.max' => 'Your phone number must be at least 5 digits',
        ];
        //temporary


//        if (is_numeric($input['emailorphone'])) {
//            $rules = [
////                'emailorphone' => ['required', 'min:5', 'max:13', new Ykcheckexist]
//                                'emailorphone' => ['required', 'numeric|min:5|max:13', new Ykcheckexist]
//
//            ];
//            $message = [
//                'emailorphone.required' => 'Email Or Phone Required',
//                'emailorphone.min' => 'Your phone number must be at least 5 digits',
//                'emailorphone.max' => 'Your phone number must be at least 5 digits',
//            ];
//        } else {
//            $rules = [
//                'emailorphone' => ['required', 'email', 'max:210', 'exists:App\Shopowner,email'],
//            ];
//            $message = [
//                'emailorphone.email' => 'Wrong Email',
//                'emailorphone.exists' => 'Your Email is not exist in our record',
//            ];
//        }

        $validate = Validator::make($input, $rules, $message);
        if ($validate->fails()) {
            if(Str::contains(url()->current(),'shop_owner')) {

                return redirect()->back()->withErrors($validate)->withInput();
            }else{
                return response()->json(['success' => false,
                    'errors' => $validate->getMessageBag()->toArray()]);

            }
        } else {
            $sendcheck = $this->sendResetCode($input);
//            return $sendcheck;
            if ($sendcheck == 'done') {
                if(Str::contains(url()->current(),'shop_owner')){
                    return view('auth.passwords.codecheck', ['emailorphone' => $input['emailorphone']]);

                }else{
                     return response()->json(['success' => true,
                         'errors' => []]);
                }
            } else {
                return $sendcheck;
            }
        }

    }


    public function add_new_password(Request $request)

    {

        $input = $request->except('_token', '_method');


        if (is_numeric($input['code'])) {
            $tocheck = Passwordresetforshop::where([['emailorphone', '=', $input['emailorphone']], ['code', '=', $input['code']],['status', '=', 'forgotpassword'], ['expire_at', '>', Carbon::now()]]);
            if ($tocheck->count() != 0) {
                if(Str::contains(url()->current(),'shop_owner')) {

                    $validate = Validator::make($input, [

                        'password' => ['required', 'string', 'min:8', 'confirmed'],


                    ]);
                }
                else{
                    $validate = Validator::make($input, [

                        'password' => ['required', 'numeric', 'min:9999','max:999999', 'confirmed'],


                    ]);
                }
                if ($validate->fails()) {
                    if(Str::contains(url()->current(),'shop_owner')) {

                        return view('auth.passwords.newpassword', ['code' => $input['code'], 'emailorphone' => $input['emailorphone']])->withErrors($validate)->withInput($request->flash());
                    }else{
                        return response()->json(['success' => false,
                            'errors' => $validate->getMessageBag()->toArray()]);

                    }
                } else {

                    $newpsw = Hash::make($input['password']);
                    if (is_numeric($input['emailorphone'])) {
                        $checkuser = Shopowner::Where('main_phone', $input['emailorphone']);
                        if ($checkuser->count() != 0) {
                            $checkuser->update(['password' => $newpsw]);
                            $logined = Auth::guard('shop_owner')->attempt(['main_phone' => $input['emailorphone'], 'password' => $input['password']]);
                        } else {
                            $checkmanager=ShopRole::where('phone', $input['emailorphone']);
                            if($checkmanager->count() != 0){
                                $checkmanager->update(['password' => $newpsw]);
                                $logined = Auth::guard('shop_role')->attempt(['phone' => $input['emailorphone'], 'password' => $input['password']]);

                            }else{
                                User::where('phone',$input['emailorphone'])->update(['password'=>$newpsw]);
                                $logined = Auth::attempt(['phone' => $input['emailorphone'], 'password' => $input['password']]);

                            }


                        }
                        if ($logined) {
                            if(Str::contains(url()->current(),'shop_owner')){
                                return redirect()->route('backside.shop_owner.detail');

                            }else{
                                \Illuminate\Support\Facades\Session::flash('change_psw', 'Your Passwrod Was Successfully Changed');

                                return response()->json(['success' => true,
                                    'redirect' => url('/')]);
                            }

                        }
                    } else {
                        $checkuser = Shopowner::Where('email', $input['emailorphone']);
                        if ($checkuser->count() != 0) {

                            $checkuser->update(['password' => $newpsw]);
                            $logined = Auth::guard('shop_owner')->attempt(['email' => $input['emailorphone'], 'password' => $input['password']]);
                            if ($logined) {
                                if(Str::contains(url()->current(),'shop_owner')){
                                    return redirect()->route('backside.shop_owner.detail');

                                }else{
                                    \Illuminate\Support\Facades\Session::flash('change_psw', 'Your Passwrod Was Successfully Changed');

                                    return response()->json(['success' => true,
                                        'redirect' => url('/')]);
                                }
                            }
                        } else {

                            return 'something wrong';
                        }
                    }

                }
            } else {
                return 'expired';
            }

        } else {
            return 'somethign wrong';
        }

    }


    public function codeCheck(Request $request)
    {
        $input = $request->except('_token', 'method');
        if (is_numeric($input['code'])) {
            $tocheck = Passwordresetforshop::where([['status', '=', 'forgotpassword'],['emailorphone', '=', $input['emailorphone']], ['code', '=', $input['code']]]);
            if ($tocheck->count() != 0) {

                if ($tocheck->first()->expire_at > Carbon::now()) {
                    if(Str::contains(url()->current(),'shop_owner')) {

                        return view('auth.passwords.newpassword', ['code' => $input['code'], 'emailorphone' => $input['emailorphone']]);
                    }else{
                        return response()->json(['success' => true,
                            'errors' => 0]);
                    }
                } else {
                    if(Str::contains(url()->current(),'shop_owner')) {

                        return 'your code is expire';
                    }else{
                        return response()->json(['success' => false,
                            'errors' => 'your code is expire']);
                    }
                }
            } else {
                if(Str::contains(url()->current(),'shop_owner')) {
                    return view('auth.passwords.codecheck', ['emailorphone' => $input['emailorphone'], 'code' => $input['code'], 'error' => 'wrong code']);

                }else{
                    return response()->json(['success' => false,
                        'errors' => 'wrong code']);
                }

            }
        } else {
            if(Str::contains(url()->current(),'shop_owner')) {
                return view('auth.passwords.codecheck', ['emailorphone' => $input['emailorphone'], 'code' => $input['code'], 'error' => 'wrong code']);

            }else{
                return response()->json(['success' => false,
                    'errors' => 'wrong code']);
            }

        }

    }


    public function sendResetCode($input)
    {

        $generate_code = rand(100000, 999999);

        $to_check_code = Passwordresetforshop::where([['emailorphone','=', $input['emailorphone']],['status', '=', 'forgotpassword']]);
        if ($to_check_code->count() != 0) {
            if ($to_check_code->first()->expire_at > Carbon::now()) {
                $get_try_count=Passwordresetforshop::where([['emailorphone','=', $input['emailorphone']],['status', '=', 'forgotpassword']])->first()->try_counts;
                if($get_try_count > 15){
                    if(Str::contains(url()->current(),'shop_owner')) {
                        return 'too many attempts please wait 1 hour';

                    }else{
                        return response()->json(['success' => false,
                            'errors' => ['emailorphone'=>['Too Many Attempt']]]);
                    }
                }else{
                    $get_try_count +=1;
                    $setdata = Passwordresetforshop::where([['emailorphone','=', $input['emailorphone']],['status', '=', 'forgotpassword']])->update(['code' => $generate_code, 'expire_at' => Carbon::now()->addMinutes(30),'try_counts'=>$get_try_count]);
                }

            } else {
                $setdata = Passwordresetforshop::where([['emailorphone','=', $input['emailorphone']],['status', '=', 'forgotpassword']])->update(['code' => $generate_code, 'expire_at' => Carbon::now()->addMinutes(30),'try_counts'=>0]);

            }


        } else {
            $input['code'] = $generate_code;
            $input['expire_at'] = Carbon::now()->addMinutes(30);
            $input['status']='forgotpassword';
            $setdata = Passwordresetforshop::create($input);

        }


        if (is_numeric($input['emailorphone'])) {
//            return 'phone';
            if ($setdata) {
                $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $input['emailorphone'], 'message' => $generate_code, "sender" => "SHWE SHOPS"]);
                if ($response->throw()->json()['status']) {
                    $response = 'done';
                } else {
                    $response = 'something wrong';
                }

                return $response;
            }
        } else {
            return 'please set phone number';


            if ($setdata) {
                Mail::to($input['emailorphone'])->send(new YkpswresetMail($generate_code));
                return 'done';

            }

        }
    }


}
