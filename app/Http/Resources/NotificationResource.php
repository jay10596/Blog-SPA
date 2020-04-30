<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_name' => $this->data['user_name'],
            'user_avatar' => $this->data['user_avatar'],
            'question' => $this->data['question'],
            'path' => $this->data['path'],
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
