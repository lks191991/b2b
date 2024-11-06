<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendForgotPasswordToUserMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $token)
    {
        $this->data = $data;
		$this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $adminuser_details = (array)$this->data;
        $adminuser_details['token'] = $this->token;
		$this->subject("Password Reset Link");

        return $this->markdown('emails.ForgotPasswordEmail', compact('adminuser_details'));
    }
}
