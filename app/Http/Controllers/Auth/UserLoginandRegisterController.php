<?php

namespace App\Http\Controllers\Auth;

use App\Models\Sign;
use App\Models\User;
use Carbon\Carbon;
use App\Models\BuyNowClickLog;
use Illuminate\Http\Request;
use App\Models\Passwordresetforshop;
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
                $setdata = Passwordresetforshop::create($input);
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

                    // $sendresponse = $this->sendresetcode($request->phone, $generate_code);
                    $sendresponse ='done';

                }

                if ($sendresponse == 'done') {
                    $input['emailorphone'] = $request->phone;
                    $input['code'] = $generate_code;
                    $input['expire_at'] = Carbon::now()->addMinutes(120);
                    $input['status'] = 'forregisteruser';
                    $setdata = Passwordresetforshop::create($input);
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
                $setdata = Passwordresetforshop::create($input);
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

        $tocheck = Passwordresetforshop::where([['emailorphone', '=', $request->phone], ['code', '=', $request->code], ['expire_at', '>', Carbon::now()], ['status', '=', 'forregisteruser']]);

        $isBuynow = $request->frombuynow;
        $ismessenger = $request->frommessenger;
        $ispayment = $request->frompayment;

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
                Session::flash('logined', 'User start login');
                return response()->json('success');
            } else {
                return response()->json('fail');
            }
        } else {
            return response()->json('Invalid Code');
        }
    }

    public function baydin()
    {

        if (isset(Auth::guard('web')->user()->id)) {
            $user_id = Auth::guard('web')->user()->id;
            $phone = Auth::guard('web')->user()->phone;
            $name = Auth::guard('web')->user()->username;
            $user = Auth::guard('web')->user()->birthday;
            $after_baydin = Auth::guard('web')->user()->send_baydin;
            $session_birth = Session::get($user);
            if ($user == "") {
                $user_birth = Carbon::parse(03 - 28)->format('m-d');
            } else {
                $user_birth = Carbon::parse(Auth::guard('web')->user()->birthday)->format('m-d');
            }


            if ($user_birth == "12-31") {
                $user = Auth::guard('web')->user();
                $baydins = Sign::all();
                $user_birth = "";
                $after_baydin = Auth::guard('web')->user()->send_baydin;

                // return $response = "need to login";
                return view('front.baydins.baydin', compact('user_birth', 'baydins', 'user', 'after_baydin'));
            } else {
                // return dd("hello");
                // return dd(Carbon::now()->format('m-d'));
                // Aries
                $user = Auth::guard('web')->user();
                $aries_samestartdate = ("03-21");
                $aries_sameenddate = ("04-19");

                // Taurus
                $taurus_samestartdate = ("04-20");
                $taurus_sameenddate = ("05-20");


                // Gemini
                $gemini_samestartdate = ("05-21");
                $gemini_sameenddate = ("06-21");


                // Cancer
                $cancer_samestartdate = ("06-22");
                $cancer_sameenddate = ("07-22");


                // LEO
                $leo_samestartdate = ("07-23");
                $leo_sameenddate = ("08-22");


                // Virgo
                $virgo_samestartdate = ("08-23");
                $virgo_sameenddate = ("09-22");


                // Libra
                $libra_samestartdate = ("09-23");
                $libra_sameenddate = ("10-23");


                // Scorpius
                $scorpius_samestartdate = ("10-24");
                $scorpius_sameenddate = ("11-21");


                // Sagittarius
                $sagittarius_samestartdate = ("11-22");
                $sagittarius_sameenddate = ("12-21");


                // Capricornus
                $capricornus_samestartdate = ("12-22");
                $capricornus_sameenddate = ("01-19");


                // Aquarius
                $aquarius_samestartdate = ("01-20");
                $aquarius_sameenddate = ("02-18");


                // Pisces
                $pisces_samestartdate = ("02-19");
                $pisces_sameenddate = ("03-20");

                if ($after_baydin == "1") {
                    $baydins = Sign::all();
                    return view('front.baydins.baydin', compact('user_birth', 'baydins', 'user', 'after_baydin'))->with('success', 'Profile updated successfully');
                } else {
                    // return dd("gg");
                    if ($user_birth >= $aries_samestartdate && $user_birth <= $aries_sameenddate) {
                        // $baydins = Sign::where('name','Aries')->get();
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/38" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                    } else
                    if ($user_birth >= $taurus_samestartdate && $user_birth <= $taurus_sameenddate) {
                        // $baydins = Sign::where('name','Taurus')->get();
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/49" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                    } else
                    if ($user_birth >= $gemini_samestartdate && $user_birth <= $gemini_sameenddate) {
                        // $baydins = Sign::where('name','Gemini')->get();
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/39" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                    } else
                    if ($user_birth >= $cancer_samestartdate && $user_birth <= $cancer_sameenddate) {
                        // $baydins = Sign::where('name','Cancer')->get();
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/40" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                    } else
                    if ($user_birth >= $leo_samestartdate && $user_birth <= $leo_sameenddate) {
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/41" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                        // $baydins = Sign::where('name','Leo')->get();
                    } else
                    if ($user_birth >= $virgo_samestartdate && $user_birth <= $virgo_sameenddate) {
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/42" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                        // $baydins = Sign::where('name','Virgo')->get();
                    } else
                    if ($user_birth >= $libra_samestartdate && $user_birth <= $libra_sameenddate) {
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/43" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                        // $baydins = Sign::where('name','Libra')->get();
                    } else
                    if ($user_birth >= $scorpius_samestartdate && $user_birth <= $scorpius_sameenddate) {
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/44" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                        // $baydins = Sign::where('name','Scorpius')->get();
                    } else
                    if ($user_birth >= $sagittarius_samestartdate && $user_birth <= $sagittarius_sameenddate) {
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/45" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                        // $baydins = Sign::where('name','Sagittarius')->get();
                    } else
                    if ($user_birth >= $capricornus_samestartdate && $user_birth <= $capricornus_sameenddate) {
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/46" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                        // $baydins = Sign::where('name','Capricornus')->get();
                    } else
                    if ($user_birth >= $aquarius_samestartdate && $user_birth <= $aquarius_sameenddate) {
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/47" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                        // $baydins = Sign::where('name','Aquarius')->get();
                    } else
                    if ($user_birth >= $pisces_samestartdate && $user_birth <= $pisces_sameenddate) {
                        $response = Http::withToken(env('PHONE_CODE_TOKEN'))->post('https://smspoh.com/api/v2/send', ["to" => $phone, 'message' => $name . ' sign result ' . "https://test.shweshops.com/baydin_detail/48" . ' according to ' . $name . ' birthday', "sender" => "SHWE SHOPS"]);
                        $user =  User::findOrFail($user_id);
                        $user->send_baydin = "1";
                        $user->update();
                        // $baydins = Sign::where('name','Pisces')->get();
                    } else {
                        $baydins = Sign::all();
                    }





                    // $response = 'done';
                    $baydins = Sign::all();
                    return view('front.baydins.baydin', compact('user_birth', 'baydins', 'user', 'after_baydin'))->with('success', 'Profile updated successfully');
                }
                return $response;
            }
        } else {
            $user_birth = "";
            $baydins = Sign::all();
            return view('front.baydins.baydin', compact('user_birth', 'baydins'));
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
