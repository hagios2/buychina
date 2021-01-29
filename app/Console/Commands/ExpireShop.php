<?php

namespace App\Console\Commands;

use App\Merchandiser;
use App\MerchandiserPayment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'merchandiser:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire Shop Payment Status';

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
        $paid_shops = Merchandiser::where('payment_status', 'paid')->latest();

        if($paid_shops->count() > 0)
        {
            $paid_shops->map(function($paid_shop){

               $payment_transaction = MerchandiserPayment::where([['merchandiser_id', $paid_shop->id], ['status' => 'success']])->latest()->first();

               if(Carbon::parse($payment_transaction->created_at)->diffInMonths(Carbon::today()) >= 1)
               {
                   $paid_shop->update(['payment_status' => 'expired']);
               }

            });
        }

    }
}
