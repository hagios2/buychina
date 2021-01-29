<?php

namespace App\Console\Commands;

use App\Merchandiser;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TerminateShopFreeTrialMode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $shops = Merchandiser::where('payment_status', 'free')->latest()->get();

        if($shops->count() > 0)
        {
            $shops->map(function($shop){

                if(Carbon::parse($shop->qualified_for_free_trial)->diffInMonths(Carbon::today()) >= 3)
                {
                    $shop->update(['payment_status' => 'payment required']);
                }

            });
        }
    }
}
