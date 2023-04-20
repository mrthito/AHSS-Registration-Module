<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessful extends Notification
{
    use Queueable;

    public $user, $price, $invoice_url;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $price, $invoice_url)
    {
        $this->user = $user;
        $this->price = $price;
        $this->invoice_url = $invoice_url;
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
                    ->subject('Your payment has been successful')
                    ->greeting('Hello ' . $this->user->user_login)
                    ->line('Thanks your payment has been successful with the amount of $' . $this->price . '.')
                    ->action('View Invoice', $this->invoice_url)
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
