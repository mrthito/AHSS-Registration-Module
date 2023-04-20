<?php

namespace App\Http\Controllers\Api;

use App\Helper\SaveData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Helper\PasswordHash as HelperPasswordHash;
use Carbon\Carbon;

class WordpressController extends Controller
{
    public function index($user_id)
    {
        $user = DB::table('users')->where('id', $user_id)->first();

        // Get user meta for user level:
        $user_level = DB::table('usermeta')->where('user_id', $user_id)->where('meta_key', 'user_level')->first();

        // Get level details:
        $level = DB::table('pmpro_membership_levels')->where('id', $user_level->meta_value)->first();

        $chargable_amount = $level->initial_payment;
        if ($chargable_amount == 0) {
            Notification::route('mail', $user->user_email)->notify(new \App\Notifications\ApprovalMessageForUser(
                $user,
                $level->initial_payment,
                $level->billing_amount,
                $level->name
            ));
        } else {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            // Create a Customer:
            $customer = \Stripe\Customer::create([
                'email' => $user->user_email,
                'name' => $user->user_login,
                'description' => 'Customer for ' . $user->user_login,
            ]);

            // Create a Stripe checkout session:
            $checkout_session = \Stripe\Checkout\Session::create([
                'customer' => $customer->id,
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'aud',
                        'product_data' => [
                            'name' => 'Member level: ' . ucwords($level->name)
                        ],
                        'unit_amount' => $chargable_amount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'invoice_creation' => [
                    'enabled' => true,
                    'invoice_data' => [
                        'description' => 'Invoice for ' . config('app.name'),
                        'metadata' => ['order' => uniqid()],
                        'footer' => config('app.name'),
                    ],
                ],
                'success_url' => route('stripe.success', $user_id) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel', $user_id),
            ]);

            // return redirect()->away($checkout_session->url);

            Notification::route('mail', $user->user_email)
                ->notify(new \App\Notifications\ApprovalMessageForUserWithPayment(
                    $user,
                    $checkout_session->url,
                    $level->initial_payment,
                    $level->billing_amount,
                    $level->name
                ));
        }
    }

    public function success(Request $request, $user_id)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $user = DB::table('users')->where('id', $user_id)->first();

        // Get user meta for user level:
        $user_level = DB::table('usermeta')->where('user_id', $user_id)->where('meta_key', 'user_level')->first();

        // Get level details:
        $level = DB::table('pmpro_membership_levels')->where('id', $user_level->meta_value)->first();

        // Get stripe response:
        $session = \Stripe\Checkout\Session::retrieve($request->session_id);

        // Get stripe payment intent:
        $payment_intent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
        // dd($payment_intent->toArray());

        // Get stripe invoice:
        $invoice = \Stripe\Invoice::retrieve($session->invoice);

        $billing_phone = DB::table('usermeta')->where('user_id', $user_id)->where('meta_key', 'phone_number')->first();

        DB::table('pmpro_membership_orders')->insert([
            'code' => str()->ucfirst(str()->random(10)),
            'session_id' => session()->getId(),
            'user_id' => $user_id,
            'membership_id' => $user_level->meta_value,
            'paypal_token' => '',
            'billing_name' => $session->customer_details->name,
            'billing_street' => $session->customer_details->address->line1,
            'billing_city' => $session->customer_details->address->city,
            'billing_state' => $session->customer_details->address->state ?? '00',
            'billing_zip' => $session->customer_details->address->postal_code,
            'billing_country' => $session->customer_details->address->country,
            'billing_phone' => $billing_phone->meta_value,
            'subtotal' => $level->initial_payment,
            'tax' => 0,
            'couponamount' => '',
            'checkout_id' => DB::table('pmpro_membership_orders')->max('checkout_id') + 1,
            'certificate_id' => '0',
            'certificateamount' => '',
            'total' => $level->initial_payment,
            'payment_type' => 'Stripe',
            'cardtype' => $payment_intent->charges->data[0]->payment_method_details->card->brand ?? '',
            'accountnumber' => '**** **** **** ' . $payment_intent->charges->data[0]->payment_method_details->card->last4 ?? '',
            'expirationmonth' => $payment_intent->payment_method_details->card->exp_month ?? '',
            'expirationyear' => $payment_intent->payment_method_details->card->exp_year ?? '',
            'status' => 'success',
            'gateway' => 'stripe',
            'gateway_environment' => 'live',
            'payment_transaction_id' => $payment_intent->id,
            'subscription_transaction_id' => '',
            'timestamp' => date('Y-m-d H:i:s'),
            'affiliate_id' => '',
            'affiliate_subid' => '',
            'notes' => '',
        ]);

        Notification::route('mail', $user->user_email)->notify(new \App\Notifications\PaymentSuccessful(
            $user,
            ($payment_intent->amount / 100),
            $invoice->hosted_invoice_url,
        ));

        return redirect()->away($invoice->hosted_invoice_url);
    }

    public function cancel(Request $request, $user_id)
    {
    }



    public function success_active(Request $request, $user_id)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $user = DB::table('users')->where('id', $user_id)->first();

        // Get user meta for user level:
        $user_level = DB::table('usermeta')->where('user_id', $user_id)->where('meta_key', 'user_level')->first();

        // Get level details:
        $level = DB::table('pmpro_membership_levels')->where('id', $user_level->meta_value)->first();

        // Get stripe response:
        $session = \Stripe\Checkout\Session::retrieve($request->session_id);

        // Get stripe payment intent:
        $payment_intent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
        // dd($payment_intent->toArray());

        // Get stripe invoice:
        $invoice = \Stripe\Invoice::retrieve($session->invoice);

        $billing_phone = DB::table('usermeta')->where('user_id', $user_id)->where('meta_key', 'phone_number')->first();

        DB::table('pmpro_membership_orders')->insert([
            'code' => str()->ucfirst(str()->random(10)),
            'session_id' => session()->getId(),
            'user_id' => $user_id,
            'membership_id' => $user_level->meta_value,
            'paypal_token' => '',
            'billing_name' => $session->customer_details->name,
            'billing_street' => $session->customer_details->address->line1,
            'billing_city' => $session->customer_details->address->city,
            'billing_state' => $session->customer_details->address->state ?? '00',
            'billing_zip' => $session->customer_details->address->postal_code,
            'billing_country' => $session->customer_details->address->country,
            'billing_phone' => $billing_phone->meta_value,
            'subtotal' => $level->initial_payment,
            'tax' => 0,
            'couponamount' => '',
            'checkout_id' => DB::table('pmpro_membership_orders')->max('checkout_id') + 1,
            'certificate_id' => '0',
            'certificateamount' => '',
            'total' => $level->initial_payment,
            'payment_type' => 'Stripe',
            'cardtype' => $payment_intent->charges->data[0]->payment_method_details->card->brand ?? '',
            'accountnumber' => '**** **** **** ' . $payment_intent->charges->data[0]->payment_method_details->card->last4 ?? '',
            'expirationmonth' => $payment_intent->payment_method_details->card->exp_month ?? '',
            'expirationyear' => $payment_intent->payment_method_details->card->exp_year ?? '',
            'status' => 'success',
            'gateway' => 'stripe',
            'gateway_environment' => 'live',
            'payment_transaction_id' => $payment_intent->id,
            'subscription_transaction_id' => '',
            'timestamp' => date('Y-m-d H:i:s'),
            'affiliate_id' => '',
            'affiliate_subid' => '',
            'notes' => '',
        ]);

        // wp_pmpro_memberships_users
        // get user from pmpro_memberships_users and update the enddate
        $membership_user = DB::table('pmpro_memberships_users')->where('user_id', $user_id)->latest()->first();
        // enddate should be last day of the year
        $update = [
            'status' => 'active',
            'startdate' => date('Y-m-d H:i:s'),
            'enddate' => date('Y-12-31 23:59:59'),
        ];
        DB::table('pmpro_memberships_users')->where('id', $membership_user->id)->update($update);

        Notification::route('mail', $user->user_email)->notify(new \App\Notifications\PaymentSuccessful(
            $user,
            ($payment_intent->amount / 100),
            $invoice->hosted_invoice_url,
        ));

        return redirect()->away($invoice->hosted_invoice_url);
    }

    public function pay_pending(Request $request)
    {
        // level=2&morder=NfgdXkPmW0
        $level_id = $request->level;
        $morder = $request->morder;

        $order = DB::table('pmpro_membership_orders')->where('code', $morder)->first();
        if (!$order) {
            dd('Order not found');
        }
        $user = DB::table('users')->where('id', $order->user_id)->first();
        $level = DB::table('pmpro_membership_levels')->where('id', $level_id)->first();
        // check if user has other orders
        $other_orders = DB::table('pmpro_membership_orders')->where('user_id', $order->user_id)->get();
        if ($other_orders->count() > 1) {
            $chargable_amount = $level->billing_amount;
        } else {
            $chargable_amount = $level->initial_payment;
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // Create a Customer:
        $customer = \Stripe\Customer::create([
            'email' => $user->user_email,
            'name' => $user->user_login,
            'description' => 'Customer for ' . $user->user_login,
        ]);

        // Create a Stripe checkout session:
        $checkout_session = \Stripe\Checkout\Session::create([
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'aud',
                    'product_data' => [
                        'name' => 'Member level: ' . ucwords($level->name) . '(Renewal)',
                    ],
                    'unit_amount' => $chargable_amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'invoice_creation' => [
                'enabled' => true,
                'invoice_data' => [
                    'description' => 'Invoice for ' . config('app.name'),
                    'metadata' => ['order' => uniqid()],
                    'footer' => config('app.name'),
                ],
            ],
            'success_url' => route('stripe.success.code', $morder) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel', 0),
        ]);

        return redirect()->away($checkout_session->url);
    }

    public function success_code(Request $request, $code)
    {

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // Get stripe response:
        $session = \Stripe\Checkout\Session::retrieve($request->session_id);

        // Get stripe payment intent:
        $payment_intent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
        // dd($payment_intent->toArray());

        // Get stripe invoice:
        $invoice = \Stripe\Invoice::retrieve($session->invoice);

        $order = DB::table('pmpro_membership_orders')->where('code', $code)->first();
        if ($order) {
            DB::table('pmpro_membership_orders')->where('code', $code)->update([
                'payment_type' => 'Stripe',
                'cardtype' => $payment_intent->charges->data[0]->payment_method_details->card->brand ?? '',
                'accountnumber' => '**** **** **** ' . $payment_intent->charges->data[0]->payment_method_details->card->last4 ?? '',
                'expirationmonth' => $payment_intent->payment_method_details->card->exp_month ?? '',
                'expirationyear' => $payment_intent->payment_method_details->card->exp_year ?? '',
                'status' => 'success',
                'gateway' => 'stripe',
                'gateway_environment' => 'live',
                'payment_transaction_id' => $payment_intent->id,
                'subscription_transaction_id' => '',
                'timestamp' => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->away($invoice->hosted_invoice_url);
    }

    public function uploadCSVUser(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $path = $request->file('csv_file')->store('csv', 'public');

        // Loop through the CSV file and insert the data into the wordpress users table
        $csvFile = fopen(storage_path('app/public/' . $path), 'r');

        fgetcsv($csvFile); // skip the first row

        while (($row = fgetcsv($csvFile)) !== false) {
            $user = DB::table('users')->where('user_email', $row[3])->first();
            if (!$user) {
                //14/02/2014 14:19:00
                $created = Carbon::now()->format('Y-m-d H:i:s');
                $password = (new HelperPasswordHash(8, true))->HashPassword('123456');
                $user_id = DB::table('users')->insertGetId([
                    'user_login' => $row[3],
                    'user_pass' => $password,
                    'user_nicename' => $row[1] . ' ' . $row[2],
                    'user_email' => $row[3],
                    'user_registered' => $created,
                    'user_status' => 0,
                    'display_name' => $row[1] . ' ' . $row[2],
                ]);

                // Save the user's meta data
                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'nickname',
                    'meta_value' => $row[1] . ' ' . $row[2]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'first_name',
                    'meta_value' => $row[1]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'last_name',
                    'meta_value' => $row[2]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'description',
                    'meta_value' => ''
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'rich_editing',
                    'meta_value' => 'true'
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'syntax_highlighting',
                    'meta_value' => 'true'
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'comment_shortcuts',
                    'meta_value' => 'false'
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'admin_color',
                    'meta_value' => 'fresh'
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'use_ssl',
                    'meta_value' => '0'
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'show_admin_bar_front',
                    'meta_value' => 'false'
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'locale',
                    'meta_value' => ''
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'capabilities',
                    'meta_value' => 'a:1:{s:10:"subscriber";b:1;}'
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'session_tokens',
                    'meta_value' => 'a:0:{}'
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_CardType',
                    'meta_value' => ''
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_AccountNumber',
                    'meta_value' => ''
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_ExpirationMonth',
                    'meta_value' => ''
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_ExpirationYear',
                    'meta_value' => ''
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_bfirstname',
                    'meta_value' => $row[1]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_blastname',
                    'meta_value' => $row[2]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_baddress1',
                    'meta_value' => $row[8]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_baddress2',
                    'meta_value' => ''
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_bcity',
                    'meta_value' => $row[7]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_bstate',
                    'meta_value' => $row[6]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_bzipcode',
                    'meta_value' => $row[9]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_bcountry',
                    'meta_value' => $row[5]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_bphone',
                    'meta_value' => $row[14]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_bemail',
                    'meta_value' => $row[3]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'phone_number',
                    'meta_value' => $row[14]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'country',
                    'meta_value' => $row[5]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'street',
                    'meta_value' => $row[8]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'suburb',
                    'meta_value' => $row[8]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'state_province',
                    'meta_value' => $row[6]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'postcode',
                    'meta_value' => $row[9]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'practice_name',
                    'meta_value' => $row[20]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'state_province1',
                    'meta_value' => $row[22]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'postcode1',
                    'meta_value' => $row[25]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'birth_date',
                    'meta_value' => $row[18]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'place_of_birth',
                    'meta_value' => $row[19]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'spouse_s_name',
                    'meta_value' => $row[26]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'proposer_name',
                    'meta_value' => $row[31]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'seconder_name',
                    'meta_value' => $row[32]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'degrees_and_diplomas',
                    'meta_value' => $row[28]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'present_surgical_appointments',
                    'meta_value' => ''
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'publications_relevant_to_hand_surgery',
                    'meta_value' => ''
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'areas_of_interest',
                    'meta_value' => $row[49]
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'show_directory_on_this_site',
                    'meta_value' => ($row[48] == '0' ? 'Yes' : 'No')
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'show_private_directory_on_this_site',
                    'meta_value' => 'No'
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pmpro_views',
                    'meta_value' => ''
                ]);

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'pw_user_status',
                    'meta_value' => 'approved'
                ]);

                $planLevel = DB::table('pmpro_membership_levels')->first();

                SaveData::usermeta([
                    'user_id' => $user_id,
                    'meta_key' => 'user_level',
                    'meta_value' => $planLevel->id
                ]);

                DB::table('pmpro_memberships_users')->insert([
                    'user_id' => $user_id,
                    'membership_id' => $planLevel->id,
                    'code_id' => '0',
                    'initial_payment' => $planLevel->initial_payment,
                    'billing_amount' => $planLevel->billing_amount,
                    'cycle_number' => $planLevel->cycle_number,
                    'cycle_period' => $planLevel->cycle_period,
                    'billing_limit' => $planLevel->billing_limit,
                    'trial_amount' => $planLevel->trial_amount,
                    'trial_limit' => $planLevel->trial_limit,
                    'status' => 'active',
                    'startdate' => date('Y-m-d H:i:s'),
                    'enddate' => date('Y-12-31 23:59:59'),
                    'modified' => date('Y-m-d H:i:s'),
                ]);

                DB::table('pmpro_membership_orders')->insert([
                    'code' => str()->ucfirst(str()->random(10)),
                    'session_id' => session()->getId(),
                    'user_id' => $user_id,
                    'membership_id' => $planLevel->id,
                    'paypal_token' => '',
                    'billing_name' => $row[1] . ' ' . $row[2],
                    'billing_street' => $row[8],
                    'billing_city' => $row[7],
                    'billing_state' => $row[6],
                    'billing_zip' => $row[9],
                    'billing_country' => $row[5],
                    'billing_phone' => $row[14],
                    'subtotal' => $planLevel->initial_payment,
                    'tax' => 0,
                    'couponamount' => '',
                    'checkout_id' => DB::table('pmpro_membership_orders')->max('checkout_id') + 1,
                    'certificate_id' => '0',
                    'certificateamount' => '',
                    'total' => $planLevel->initial_payment,
                    'status' => 'pending',
                    'gateway' => 'stripe',
                    'gateway_environment' => 'live',
                    'subscription_transaction_id' => '',
                    'payment_transaction_id' => '',
                    'timestamp' => date('Y-m-d H:i:s'),
                    'affiliate_id' => '',
                    'affiliate_subid' => '',
                    'notes' => '',
                ]);
            }
        }
    }
}
