<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'path' => $this->path,
            'body' => $this->body,
            'created_at' => $this->created_at->diffForHumans(),

            'favourite_count' => $this->favourites->count(),
            'favourited' => !! $this->favourites->where('user_id', auth()->id())->count(),
            
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar,

            'category' => new CategoryResource($this->category),
            
            'replies' => ReplyResource::collection($this->replies)
        ];
    }
}
