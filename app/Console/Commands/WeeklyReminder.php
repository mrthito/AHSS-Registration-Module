<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class WeeklyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = DB::table('pmpro_membership_orders')
            ->where('status', 'pending')
            ->get();

            // dd($orders->toArray());

        if ($orders->count() > 0) {
            foreach ($orders as $order) {
                $user = DB::table('users')->where('ID', $order->user_id)->first();
                $level = DB::table('pmpro_membership_levels')->where('id', $order->membership_id)->first();
                
                Notification::route('mail', $user->user_email)
                    ->notify(new \App\Notifications\WeeklyReminder($user, $level));
            }
        }
    }
}
