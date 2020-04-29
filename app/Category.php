<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;


class Category extends Model
{
    protected $guarded = [];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
