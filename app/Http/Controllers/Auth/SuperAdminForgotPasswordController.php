<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SuperAdminResetEmail;
use App\Models\Superadmin;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class SuperAdminForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest:super_admin');
    }

    public function broker()
    {
        return Password::broker('super_admins');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.super-admin-email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = Superadmin::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => trans(Password::INVALID_USER)]);
        }

        $token = $this->broker()->createToken($user);

        Mail::to($user->email)->send(new SuperAdminResetEmail($user->email, $token));

        return back()->with('status', trans(Password::RESET_LINK_SENT));
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.super-admin-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $credentials = $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );

        $response = $this->broker()->reset(
            $credentials,
            function ($user, $password) {
                $this->updatePassword($user, $password);
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            return redirect()->route('backside.super_admin.login')->with('status', trans($response));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => trans($response),
                'token' => trans($response),
            ]);
    }

    protected function updatePassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
    }
}
