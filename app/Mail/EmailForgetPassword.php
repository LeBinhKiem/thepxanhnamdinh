<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }


    public function build()
    {
        return $this->from(env("MAIL_USERNAME", null))
            ->view('emails.email_forget_password')
            ->with([
                'name' => $this->emailData['name'] ?? "",
                'account' => $this->emailData['account'] ?? "",
                'password' => $this->emailData['password'] ?? "",
            ]);
    }
}
