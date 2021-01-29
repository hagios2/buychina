<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryFormMailHandler extends Mailable
{
    use Queueable, SerializesModels;

    public $formInputs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($formInputs)
    {
        $this->formInputs = $formInputs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail/EnquiryFormMail')
        
            ->subject('Enquiry from Client');
    }
}
