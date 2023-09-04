<?php

namespace App\Http\Controllers\Auth;

use App\Mail\YkpswresetMail;
use App\Models\PasswordResetForShop;
use App\Rules\Ykcheckexist;
use App\Rules\LoginTrottle;

use App\Models\Shops;
use App\Models\ShopOwnersAndStaffs;
use App\Models\User;
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

class YkforgotpasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        if (Str::contains(url()->current(), 'shop_owner')) {
            return view('auth.passwords.email');
        } else {
            return response()->json('showpasswordreset');
        }
    }

    public function send_reset_code_form(Request $request)
    {

        $input = $request->except('_token');

        //temporary

        $rules = [
            //                'emailorphone' => ['required', 'min:5', 'max:13', new Ykcheckexist]
            'emailorphone' => ['required', 'digits_between:5,13', new Ykcheckexist, new LoginTrottle]

        ];
        $message = [
            'emailorphone.required' => 'Email Or Phone Required',
            'emailorphone.digits_between' => 'Wrong Phone number',
            //            'emailorphone.max' => 'Your phone number must be at least 5 digits',
        ];
        //temporary


        $validate = Validator::make($input, $rules, $message);
        if ($validate->fails()) {
            if (Str::contains(url()->current(), 'shop_owner')) {

                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => $validate->getMessageBag()->toArray()
                ]);
            }
        } else {

            $sendcheck = $this->sendResetCode($input);
            //            return $sendcheck;
            if ($sendcheck == 'done') {
                if (Str::contains(url()->current(), 'shop_owner')) {
                    return view('auth.passwords.codecheck', ['emailorphone' => $input['emailorphone']]);
                } else {
                    return response()->json([
                        'success' => true,
                        'errors' => []
                    ]);
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
            $tocheck = PasswordResetForShop::where([['emailorphone', '=', $input['emailorphone']], ['code', '=', $input['code']], ['expire_at', '>', Carbon::now()]]);
            if ($tocheck->count() != 0) {
                if (Str::contains(url()->current(), 'shop_owner')) {

                    $validate = Validator::make($input, [

                        'password' => ['required', 'string', 'min:8', 'confirmed'],


                    ]);
                } else {
                    $validate = Validator::make($input, [

                        'password' => ['required', 'numeric', 'digits_between:6,13', 'confirmed'],


                    ]);
                }
                if ($validate->fails()) {
                    if (Str::contains(url()->current(), 'shop_owner')) {

                        return view('auth.passwords.newpassword', ['code' => $input['code'], 'emailorphone' => $input['emailorphone']])->withErrors($validate)->withInput($request->flash());
                    } else {
                        return response()->json([
                            'success' => false,
                            'errors' => $validate->getMessageBag()->toArray()
                        ]);
                    }
                } else {

                    $newpsw = Hash::make($input['password']);
                    $checkuser = ShopOwnersAndStaffs::Where('phone', $input['emailorphone']);
                    $checkuser->update(['password' => $newpsw]);

                    $logined = Auth::guard('shop_owners_and_staffs')->attempt(['phone' => $input['emailorphone'], 'password' => $input['password']]);

                    if ($logined) {
                        if (Str::contains(url()->current(), 'shop_owner')) {
                            return redirect()->route('backside.shop_owner.detail');
                        } else {
                            \Illuminate\Support\Facades\Session::flash('change_psw', 'Your Passwrod Was Successfully Changed');

                            return response()->json([
                                'success' => true,
                                'redirect' => url('/')
                            ]);
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

        $tocheck = PasswordResetForShop::where([['status', '=', 'forgotpassword'], ['emailorphone', '=', $input['emailorphone']], ['expire_at', '>', Carbon::now()], ['code', '=', $input['code']]]);
        if ($tocheck->count() != 0) {

            return response()->json([
                'success' => true,
                'errors' => 0
            ]);
        } else {
            if (Str::contains(url()->current(), 'shop_owner')) {
                return view('auth.passwords.codecheck', ['emailorphone' => $input['emailorphone'], 'code' => $input['code'], 'error' => 'wrong or expired code']);
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => 'wrong or expired code'
                ]);
            }
        }
    }


    public function sendResetCode($input)
    {

        $generate_code = rand(100000, 999999);

        $input['code'] = $generate_code;
        $input['expire_at'] = Carbon::now()->addMinutes(160);
        $input['status'] = 'forgotpassword';
        $setdata = PasswordResetForShop::create($input);



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
    }
}
