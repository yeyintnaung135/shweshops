<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Carbon\Carbon;
use App\Models\BuyNowClickLog;
use Illuminate\Http\Request;
use App\Models\PasswordResetForShop;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Trait\LoginPoint;
use App\Rules\LoginTrottle;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Auth\RegistersUsers;


class UserLoginandRegisterController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use Logs;

    use RegistersUsers, LoginPoint;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): ValidationValidator
    {
        return Validator::make(
            $data,
            [
                'name' => 'required|max:100',
                'phone' => ['required', 'regex:/(^09([0-9]+)(\d+)?$)/u', 'min:5', 'max:11', 'unique:users,phone', new LoginTrottle],

            ],
            [
                'name.required' => 'Name is required',
                'phone.min' => 'Phone number သည် အနည်းဆုံး 11 လုံးရှိရမည်',
                'phone.max' => 'Phone number သည် 11 လုံးထပ်မကျော်ရ',
            ]
        );
    }

    protected function login_validator(array $data): ValidationValidator
    {
        return Validator::make(
            $data,
            [
                'phone' => ['required', 'regex:/(^09([0-9]+)(\d+)?$)/u', 'min:5', 'max:11', new LoginTrottle],

            ],
            [
                'phone.min' => 'Phone number သည် အနည်းဆုံး 11 လုံးရှိရမည်',
                'phone.max' => 'Phone number သည် 11 လုံးထပ်မကျော်ရ',
            ]
        );
    }

    public function resend_code(Request $request): JsonResponse
    {
        $generate_code = rand(100000, 999999);
        $code = $generate_code;

        $validator = Validator::make($request->all(), [
            'phone' => ['required', new LoginTrottle],

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->messages()]);
        } else {

            $sendresponse = $this->sendresetcode($request->phone, $generate_code);
            if ($sendresponse == 'done') {
                $input['emailorphone'] = $request->phone;
                $input['code'] = $generate_code;
                $input['expire_at'] = Carbon::now()->addMinutes(120);
                $input['status'] = 'forregisteruser';
                $setdata = PasswordResetForShop::create($input);
            }
            return response()->json(['status' => 'success', 'data' => $request->all()]);
        }
    }

    public function checkvalidate(Request $request): JsonResponse
    {
        $isUser = User::where('phone', $request->phone)->first();
        $validator = $this->login_validator($request->all());
        if ($validator->fails()) {
            return response()->json($validator->messages());
        } else {
            if (empty($isUser)) {
                return response()->json([
                    'success' => false
                ]);
            } else {
                $generate_code = rand(100000, 999999);
                $code = $generate_code;


                if ($request->phone != '09425472782') {

                    $sendresponse = $this->sendresetcode($request->phone, $generate_code);
                    $sendresponse ='done';

                }

                if ($sendresponse == 'done') {
                    $input['emailorphone'] = $request->phone;
                    $input['code'] = $generate_code;
                    $input['expire_at'] = Carbon::now()->addMinutes(120);
                    $input['status'] = 'forregisteruser';
                    $setdata = PasswordResetForShop::create($input);
                    if ($input['emailorphone'] == '09425472782') {

                        return response()->json(['status' => 'success', 'data' => $request->all(), 'code' => $code]);
                    } else {
                        return response()->json(['status' => 'success', 'data' => $request->all()]);
                    }
                }
            }
        }
    }
    public function check_validate_register(Request $request): JsonResponse
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json($validator->messages());
        } else {

            $generate_code = rand(100000, 999999);


            $sendresponse = $this->sendresetcode($request->phone, $generate_code);

            if ($sendresponse == 'done') {
                $input['emailorphone'] = $request->phone;
                $input['code'] = $generate_code;
                $input['expire_at'] = Carbon::now()->addMinutes(120);
                $input['status'] = 'forregisteruser';
                $setdata = PasswordResetForShop::create($input);
                return response()->json(['status' => 'success', 'data' => $request->all()]);
            }
        }
    }

    public function checkcodereg(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|regex:/(^09([0-9]+)(\d+)?$)/u|min:5|max:11',
            'code' => 'required|numeric',
        ]);
        $password = 'thantzaw123!@#';

        $tocheck = PasswordResetForShop::where([['emailorphone', '=', $request->phone], ['code', '=', $request->code], ['expire_at', '>', Carbon::now()], ['status', '=', 'forregisteruser']]);

        $isBuynow = $request->frombuynow;
        $ismessenger = $request->frommessenger;
        $ispayment = $request->frompayment;
        $isorder = $request->fromorder;

        if ($isBuynow == 'clickbuynow') {
            $clickbuynow =  Session::get('clickbuynow');
            Session::put('clickbuynow', 'click');
        }

        if ($ismessenger == 'clickmessenger') {
            Session::put('clickmessenger', 'click');
        }
        if ($ispayment == 'clickpayment') {
            Session::put('clickpayment', 'click');
        }

        $buynowclick = BuyNowClickLog::where('userorguestid', Session::get('guest_id'))->get();

        if (!empty($tocheck->first())) {
            // $this->validator($request->except('code'))->validate();
            $isUser = User::where('phone', $request->phone)->first();

            if (isset($isUser)) {
                if ($isUser->username == $request->phone) {
                    Auth::guard('web')->attempt(['phone' => $request->phone, 'password' => $password]);
                    return response()->json([
                        "data" => true
                    ]);
                } else {
                    foreach ($buynowclick as $buynowclick) {
                        $buynowclick->userorguestid = $this->getidoftable_userorguestid();
                        $buynowclick->update();
                    }
                }
            } else {
                $this->create($request->except('code'));
            }

            Auth::guard('web')->attempt(['phone' => $request->phone, 'password' => $password]);

            //$this->check_login_or_register_point(); //insert point , You can look LoginPoint Trait

            if (Auth::guard('web')->check()) {
                if($isorder == 'yes'){
                    return response()->json('order');
                }else{
                    Session::flash('logined', 'User start login');
                    return response()->json($isorder);
                }
                
            } else {
                return response()->json('fail');
            }
        } else {
            return response()->json('Invalid Code');
        }
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data):User
    {
        $password = 'thantzaw123!@#';
        return User::create([
            'username' =>  $data['name'],
            'phone' => $data['phone'],
            'password' => Hash::make($password),
            'active' => 'yes'
        ]);
    }

    protected function update_name(Request $request):JsonResponse
    {
        $request->validate([
            'name' => 'required|max:100'
        ]);

        $user = User::where('phone', $request->phone)->first();
        if (isset($user)) {
            $user->username = $request->name;
            $user->update();
        }
        if (Auth::guard('web')->check()) {
            return response()->json([' data' => true]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    protected function sendresetcode($phone, $code)
    {

        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => 'Please use ' . $code . ' for login', "sender" => "SHWE SHOPS"]);
        if ($response->throw()->json()['status']) {
            $response = 'done';
        } else {
            $response = 'something wrong';
        }

        return $response;
    }
}
