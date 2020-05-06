<?php

namespace App\Http\Controllers;

use App\Like;
use App\Reply;

use Illuminate\Http\Request;
use App\Events\LikeEvent;
use App\Notifications\LikeNotification;


class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }
    
    public function likeIt(Reply $reply)
    {   //Creates reply
        $reply->likes()->create([ 
            'user_id' => auth()-> id(),
        ]);

        //Sends notification
        $like = Like::orderby('created_at', 'desc')->first();
        
        $user = $reply->user;
        
        if($like->user_id != $reply->user_id) {
            $user->notify(new LikeNotification($reply));
        }

        //Makes it live
        broadcast(new LikeEvent($reply->id, 1))->toOthers();
    }

    public function unlikeIt(Reply $reply)
    {
        $reply->likes()->where('user_id', auth()->id())->first()->delete();

        broadcast(new LikeEvent($reply->id, 0))->toOthers();
    }

    public function getReplies(Reply $reply)
    {
        $likedRepliesID = Like::where('user_id', auth()->id())->pluck('reply_id');
        $replies = Reply::find($likedRepliesID);

        return $replies;
    }
}
