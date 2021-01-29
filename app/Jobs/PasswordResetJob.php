<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\ApiPasswordReset;
use App\Mail\PasswordResetMail;

class PasswordResetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)
        
        ->queue(new PasswordResetMail($this->user, $this->token));
    }
}
