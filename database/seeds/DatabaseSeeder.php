<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Category;
use App\Question;
use App\Reply;
use App\Like;
use App\Favourite;


class DatabaseSeeder extends Seeder
{
    
    public function run()
    {
        factory(User::class, 10)->create();
        factory(Category::class, 5)->create();
        factory(Question::class, 10)->create();
        factory(Reply::class, 50)->create()->each(function($reply){
            return $reply->likes()->save(factory(Like::class)->make());
        });; //LikeFactory contains only user_id as reply_id will be created though relationship
        factory(Favourite::class, 10)->create(); //Both question_id and user_id are created in the factory the normal way
    }
}
