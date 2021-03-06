<?php

namespace App\Http\Resources;
use Carbon\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'birthday' => $this->birthday->format('m/d/Y'),
            'email' => $this->email,
            'avatar' => $this->avatar,
            'questions' => QuestionResource::collection($this->questions)
        ];
    }
}
