<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Http\Resources\ReplyResource;

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
        return ['database', 'broadcast'];
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

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'questionOrReply' => $this->reply->question->title,
            'path' => $this->reply->question->path,
            'message' => 'replied on your post.',
            'reply' => new ReplyResource($this->reply)
        ]);
    }
}
