<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShopPasswordResetMail;
use App\Merchandiser;
use App\ApiPasswordReset;

class ShopPasswordResetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $shop;

    public $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function construct(Merchandiser $shop, ApiPasswordReset $token)
    {
        $this->shop = $shop;

        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->shop)
        
        ->queue(new ShopPasswordResetMail($this->shop, $this->token));
        
    }
}
