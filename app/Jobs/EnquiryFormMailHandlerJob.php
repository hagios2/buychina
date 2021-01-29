<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\EnquiryFormMailHandler;
use Illuminate\Support\Facades\Mail;
use Swift_Mailer;
use Swift_SmtpTransport;

class EnquiryFormMailHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $formInputs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($formInputs)
    {
        $this->formInputs = $formInputs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Backup your default mailer
       // $backup = Mail::getSwiftMailer();

        // Setup your gmail mailer
       // $transport = (new Swift_SmtpTransport('smtp.gmail.com',587, 'tls'));

      //  $transport->setUsername(env('MAIL_USERNAME1'));
       // $transport->setPassword(env('MAIL_PASSWORD1'));

      //  $gmail = new Swift_Mailer($transport);

        // Set the mailer as gmail
      //  Mail::setSwiftMailer($gmail);

        // Send your message
        Mail::to(env('MAIL_USERNAME'))

            ->queue(new EnquiryFormMailHandler($this->formInputs)
        );

        // Restore your original mailer
       // Mail::setSwiftMailer($backup);



    }
}
