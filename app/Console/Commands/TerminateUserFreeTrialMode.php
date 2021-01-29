<?php

namespace App\Console\Commands;

use App\Merchandiser;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TerminateUserFreeTrialMode extends Command
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
        $users = User::where('qualified_for_free_trial', true)->latest()->get();

        if($users->count() > 0)
        {
            $users->map(function($user){

                if(Carbon::parse($user->created_at)->diffInMonths(Carbon::today()) >= 3)
                {
                    $user->update(['qualified_for_free_trial' => false]);
                }

            });
        }
    }
}
