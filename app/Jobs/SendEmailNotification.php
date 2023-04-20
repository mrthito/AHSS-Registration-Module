<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    /**
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $user = $this->user;

        // Get user id:
        $user_id = $user->ID;

        // Get user meta for user level:
        $user_level = DB::table('usermeta')->where('user_id', $user_id)->where('meta_key', 'user_level')->first();
        // dd($user_level->meta_value);
        if ((int)$user_level->meta_value > 0) {
            // Get level details:
            $level = DB::table('pmpro_membership_levels')->where('id', $user_level->meta_value)->first();
            if ($level) {

                $chargable_amount = $level->billing_amount;
                if ($chargable_amount == 0) {
                    // Set member active
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
                                    'name' => 'Member level(Renew): ' . ucwords($level->name)
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
                        'success_url' => route('stripe.success.active', $user_id) . '?session_id={CHECKOUT_SESSION_ID}',
                        'cancel_url' => route('stripe.cancel', $user_id),
                    ]);

                    // return redirect()->away($checkout_session->url);

                    Notification::route('mail', $user->user_email)
                        ->notify(new \App\Notifications\SendRenewLink(
                            $user,
                            $checkout_session->url,
                            $chargable_amount,
                            $level->name
                        ));
                }
            }
        }
    }
}
