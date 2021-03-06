<?php

namespace Modules\Users\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserCreated extends Notification
{
    use Queueable;

    /**
     * @var \App\User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title'    => 'New User',
            'msg'      => 'User ' . $this->user->full_name . ' has been successfully created',
            'url'      => '#',
            'icon'     => 'UserPlusIcon',
            'time'     => $this->user->created_at->format('c'),
            'category' => 'primary',
        ];
    }
}
