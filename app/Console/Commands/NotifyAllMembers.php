<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NotifyAllMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all members on last day of year';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // select all users whose user_id are also in pmpro_memberships_users
        $users = DB::table('users')
            ->leftJoin('pmpro_memberships_users', 'users.ID', '=', 'pmpro_memberships_users.user_id')
            ->select('users.*')
            ->orderBy('users.ID', 'desc')
            ->where('users.ID', 562)
            ->get();

        // dd($users->toArray());

        if ($users->count() > 0) {
            foreach ($users as $user) {
                $notify = new \App\Jobs\SendEmailNotification($user);
                dispatch($notify);
            }
        }
    }
}
