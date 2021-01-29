<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Merchandiser;
use App\ApiPasswordReset;

class ShopPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $shop;

    public $token;
    /**
     * Create a new message.
     *
     * @return void
     */
    public function construct(Merchandiser $shop, ApiPasswordReset $token)
    {
        $this->shop = $shop;

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.ShopPasswordResetMail')
            ->subject('Password Reset');
    }
}
