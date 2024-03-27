<?php

namespace App\Console\Commands;

use App\Models\Membership;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DailyStatusCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-status-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Subscription and Membership status daily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $memberships_status = Membership::where('mem_end_date', '<', Carbon::today())->get();
        foreach ($memberships_status as $mem){
            Membership::where('id', $mem->id)
            ->update(['mem_status'=>"expired"]);
        }
        $subscription_status = Membership::where('sub_end_date', '<', Carbon::today())->get();
        foreach ($subscription_status as $mem){
            Membership::where('id', $mem->id)
            ->update(['mem_status'=>"expired"]);
        }
    }
}
