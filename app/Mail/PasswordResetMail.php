<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\ApiPasswordReset;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, ApiPasswordReset $token)
    {
        $this->user = $user;

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.PasswordResetMail')
        ->subject('Password Reset');
    }
}
