<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendRenewLink extends Notification
{
    use Queueable;

    public $user, $link, $amount, $level_name;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $link, $amount, $level_name)
    {
        $this->user = $user;
        $this->link = $link;
        $this->amount = $amount;
        $this->level_name = $level_name;
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
            ->subject('Your Membership Level Has Expired. Please renew your membership.')
            ->greeting('Hello ' . $this->user->user_login . ',')
            ->line('Your subscription for ' . $this->level_name . ' membership level has expired.')
            ->line('The renew price for membership is $' . round($this->amount, 2) . ' per Year.')
            ->action('Renew Subscription', $this->link)
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
