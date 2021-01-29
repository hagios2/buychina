<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Admin;
use App\Mail\NewAdminRegistration;

class NewAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $admin;
    
    public $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Admin $admin, $password)
    {
        $this->admin = $admin;

        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->admin)
        
        ->queue(new NewAdminRegistration($this->admin, $this->password));

    }
}
