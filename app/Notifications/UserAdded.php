<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserAdded extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $email,
        public string $password,
        public string $role
    ) {
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
            ->subject('Registeration successful on ' . config('app.name'))
            ->greeting('Hello!')
            ->line('You have been added to ' . config('app.name') . ' as ' . $this->role . '.')
            ->line('You can login using the following credentials.')
            ->line('Email: ' .  $this->email)
            ->line('Password: ' . $this->password)
            ->line('Thanks,');
    }
}
