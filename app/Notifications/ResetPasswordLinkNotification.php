<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class ResetPasswordLinkNotification extends Notification
{

    private string $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        \URL::forceRootUrl(\config('app.url'));
        return (new MailMessage)
            ->line('Use this link to reset your password:')
            ->line(url('/reset-pw?') . http_build_query(['token' => $this->token]));
    }
}
