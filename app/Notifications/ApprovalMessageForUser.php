<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalMessageForUser extends Notification
{
    use Queueable;

    public $user, $price1, $price2, $plan_name;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $price1, $price2, $plan_name)
    {
        $this->user = $user;
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
            ->line('The price for membership is $' . $this->price1 . ' now and then $' . $this->price2 . ' per Year.')
            ->line('You can now Login with your credentials into our application.')
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
