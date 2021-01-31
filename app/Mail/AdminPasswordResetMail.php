<?php

namespace App\Mail;

use App\Admin;
use App\ApiPasswordReset;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminPasswordResetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $admin;

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Admin $admin, ApiPasswordReset $token)
    {
        $this->admin = $admin;

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.AdminPasswordResetMail')
            ->subject('Password Reset');
    }
}
