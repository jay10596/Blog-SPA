<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Reply;
use App\Category;


class Question extends Model
{
    //protected $guarded = []; //$Not suitable for $request->all()

    protected $fillable = ['title', 'slug', 'body', 'category_id', 'user_id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPathAttribute()
    {
        return "/questions/$this->slug";
    }
    
    protected $with = ['replies', 'category'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
