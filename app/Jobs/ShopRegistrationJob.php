<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\VerifyEmail;
use App\Mail\ShopRegistrationMail;
use App\Merchandiser;
use Illuminate\Support\Facades\Mail;

class ShopRegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->merchandiser)->send(new ShopRegistrationMail($this->merchandiser, $this->token));
    }
}
