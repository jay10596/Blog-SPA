<?php

namespace App\Http\Controllers;

use App\Like;
use App\Reply;

use Illuminate\Http\Request;
use App\Events\RemoveLikeEvent;
use App\Notifications\LikeNotification;


class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }
    
    public function likeIt(Reply $reply)
    {   //Adds like
        $reply->likes()->create([ 
            'user_id' => auth()-> id(),
        ]);

        //Sends notification
        $like = Like::orderby('created_at', 'desc')->first();
        
        $user = $reply->user;
        
        if($like->user_id != $reply->user_id) {
            $user->notify(new LikeNotification($reply));
        }
    }

    public function unlikeIt(Reply $reply)
    {   //Removes Like
        $reply->likes()->where('user_id', auth()->id())->first()->delete();

        //Makes it live
        broadcast(new RemoveLikeEvent($reply->id))->toOthers();
    }

    public function getReplies(Reply $reply)
    {
        $likedRepliesID = Like::where('user_id', auth()->id())->pluck('reply_id');
        $replies = Reply::find($likedRepliesID);

        return $replies;
    }
}
