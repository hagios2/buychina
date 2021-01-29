<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistrationMail;
use App\VerifyEmail;

class UserRegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, VerifyEmail $token)
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
        
            ->queue(new UserRegistrationMail($this->user, $this->token)
        );
    }
}
