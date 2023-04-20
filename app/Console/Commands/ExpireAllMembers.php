<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireAllMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire all members on last day of year';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = DB::table('users')
            ->leftJoin('pmpro_memberships_users', 'users.ID', '=', 'pmpro_memberships_users.user_id')
            ->select('users.*')
            ->get();

        if ($users->count() > 0) {
            foreach ($users as $user) {
                $membership_user = DB::table('pmpro_memberships_users')
                    ->where('user_id', $user->ID)
                    ->where('initial_payment', '>', 0)
                    ->where('billing_amount', '>', 0)
                    ->where('status', 'active')
                    ->first();
                if ($membership_user) {
                    // enddate should be last day of the year
                    $update = [
                        'status' => 'expired'
                    ];
                    DB::table('pmpro_memberships_users')->where('id', $membership_user->id)->update($update);
                }
                // Last order
                $order = DB::table('pmpro_membership_orders')->where('user_id', $user->ID)->latest()->first();


                if ($order) {

                    $status = 'pending';

                    $level = DB::table('pmpro_membership_levels')->where('id', $order->membership_id)->first();
                    if($level->initial_payment == 0 && $level->billing_amount == 0) {
                        $status = 'success';
                    }
                    // duplicate order
                    $duplicate_order = $order;
                    $duplicate_order->code = str()->ucfirst(str()->random(10));
                    $duplicate_order->session_id = session()->getId();
                    $duplicate_order->subtotal = $level->billing_amount;
                    $duplicate_order->checkout_id = DB::table('pmpro_membership_orders')->max('checkout_id') + 1;
                    $duplicate_order->total = $level->billing_amount;
                    $duplicate_order->payment_type = '';
                    $duplicate_order->cardtype = '';
                    $duplicate_order->accountnumber = '';
                    $duplicate_order->expirationmonth = '';
                    $duplicate_order->expirationyear = '';
                    $duplicate_order->status = $status;
                    $duplicate_order->payment_transaction_id = '';
                    $duplicate_order->timestamp = date('Y-m-d H:i:s');
                    $duplicate_order->save();
                } else {
                    $level = DB::table('pmpro_membership_levels')->where('id', $membership_user->membership_id)->first();
                    $status = 'pending';
                    if($level->initial_payment == 0 && $level->billing_amount == 0) {
                        $status = 'success';
                    }
                    // get user meta
                    $meta = DB::table('usermeta')->where('user_id', $user->ID)->get();
                    $newArray = [];
                    if ($meta->count() > 0) {
                        foreach ($meta as $m) {
                            $newArray[$m->meta_key] = $m->meta_value;
                        }
                    }
                    // Create Unpaid Order
                    DB::table('pmpro_membership_orders')->insert([
                        'code' => str()->ucfirst(str()->random(10)),
                        'session_id' => session()->getId(),
                        'user_id' => $user->ID,
                        'membership_id' => $level->id,
                        'paypal_token' => '',
                        'billing_name' => $newArray['first_name'] . ' ' . $newArray['last_name'],
                        'billing_street' => $newArray['street'],
                        'billing_city' => $newArray['suburb'],
                        'billing_state' => $newArray['state_province'],
                        'billing_zip' => $newArray['postcode'],
                        'billing_country' => $newArray['country'],
                        'billing_phone' => $newArray['pmpro_bphone'],
                        'subtotal' => $level->initial_payment,
                        'tax' => 0,
                        'couponamount' => '',
                        'checkout_id' => DB::table('pmpro_membership_orders')->max('checkout_id') + 1,
                        'certificate_id' => '0',
                        'certificateamount' => '',
                        'total' => $level->initial_payment,
                        'payment_type' => 'Stripe',
                        'cardtype' => '',
                        'accountnumber' => '',
                        'expirationmonth' => '',
                        'expirationyear' => '',
                        'status' => $status,
                        'gateway' => 'stripe',
                        'gateway_environment' => 'live',
                        'payment_transaction_id' => '',
                        'subscription_transaction_id' => '',
                        'timestamp' => date('Y-m-d H:i:s'),
                        'affiliate_id' => '',
                        'affiliate_subid' => '',
                        'notes' => '',
                    ]);
                }
            }
        }
    }
}
