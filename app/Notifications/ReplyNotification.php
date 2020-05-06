<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Reply;

class ReplyNotification extends Notification
{
    use Queueable;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'questionOrReply' => $this->reply->question->title,
            'path' => $this->reply->question->path,
            'message' => 'replied on your post.'
        ];
    }
}
