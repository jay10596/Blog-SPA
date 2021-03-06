<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,

            'question_id' => $this->question->id,

            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar,
            
            'like_count' => $this->likes->count(),
            'liked' => !! $this->likes->where('user_id', auth()->id())->count(),
            
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
