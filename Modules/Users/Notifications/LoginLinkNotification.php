<?php

namespace Modules\Users\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginLinkNotification extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    private $to;
    /**
     * @var \App\User
     */
    private $user;
    /**
     * @var string
     */
    private $host;

    public function __construct(User $user, string $host, string $to = null)
    {
        $this->to = $to;
        $this->user = $user;
        $this->host = $host;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
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
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->host . '/magiclink/' . $notifiable->api_token . '?' . http_build_query(['to' => $this->to]);

        return (new MailMessage())
            ->subject('Herzlich willkommen beim ' .  env('APP_NAME', 'SellFirst Portal') )
            ->view('emails.users.created', ['homeUrl' => $this->host, 'url' => $url]);
    }
}
