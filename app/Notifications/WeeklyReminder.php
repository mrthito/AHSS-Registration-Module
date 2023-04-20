<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeeklyReminder extends Notification
{
    use Queueable;

    public $user, $level;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $level)
    {
        $this->user = $user;
        $this->level = $level;
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
            ->subject('Weekly Reminder of Unpaid membership')
            ->greeting('Hello ' . $this->user->display_name . ',')
            ->line('You have not paid for your membership yet. Please pay for your membership by clicking the button below.')
            ->action('Pay Now', 'https://surgerysociety.unipegasusinfotechsolutions.com/membership-account')
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
