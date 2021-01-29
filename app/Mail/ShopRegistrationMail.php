<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\VerifyEmail;
use App\Merchandiser;

class ShopRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public $merchandiser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Merchandiser $merchandiser, VerifyEmail $token)
    {
        $this->merchandiser = $merchandiser;

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail/ShopRegistrationMail')
            
        ->subject('Confirm Email');
    }
}
