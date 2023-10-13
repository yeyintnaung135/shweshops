<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;

class BayDinController extends Controller
{
    //
    public function baydin_detail(Request $request, $id): mixed
    {
        $baydin = Sign::findOrFail($id);
        $sign = $baydin->name;
        $baydins = Sign::where('id', '!=', $id)->where('name', $sign)->get();
        // return dd($baydins);
        if (isset(Auth::guard('web')->user()->id)) {
            return view('front.baydins.baydin_detail', compact('baydin', 'baydins'));
        } else {
            return redirect()->back();
        }
    }
    public function baydin(): View
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
            }
        } else {
            $user_birth = "";
            $baydins = Sign::all();
            return view('front.baydins.baydin', compact('user_birth', 'baydins'));
        }
    }
}
