<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalMessageForUserWithPayment extends Notification
{
    use Queueable;

    public $user, $payment_url, $price1, $price2, $plan_name;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $payment_url, $price1, $price2, $plan_name)
    {
        $this->user = $user;
        $this->payment_url = $payment_url;
        $this->price1 = $price1;
        $this->price2 = $price2;
        $this->plan_name = $plan_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your application has been approved')
            ->greeting('Hello ' . $this->user->user_login)
            ->line('Thanks your application has been approved. You have selected the ' . $this->plan_name . ' membership level.')
            ->line('The price for membership is $' . round($this->price1, 2) . ' now and then $' . round($this->price2, 2) . ' per Year.')
            ->line('Please find the payment link as below :')
            ->action('Pay Now', $this->payment_url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
