<?php

namespace App\Mail;

use App\Superadmin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class SuperAdminResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $token;
    public $resetUrl;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
        $this->resetUrl = URL::route('backside.super_admin.password.reset', ['email' => $this->email, 'token' => $this->token]);
    }

    public function build()
    {
        return $this->subject('Reset Password')
            ->view('mail.super-admin-reset')
            ->with([
                'resetUrl' => $this->resetUrl,
            ]);
    }
}
