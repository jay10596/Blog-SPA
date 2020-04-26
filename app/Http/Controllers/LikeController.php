<?php

namespace App\Http\Controllers;

use App\Like;
use App\Reply;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }
    
    public function likeIt(Reply $reply)
    {
        $reply->likes()->create([ 
            'user_id' => auth()-> id(),
        ]);
    }

    public function unlikeIt(Reply $reply)
    {
        $reply->likes()->where('user_id', auth()->id())->first()->delete();
    }

    public function getReplies(Reply $reply)
    {
        $likedRepliesID = Like::where('user_id', auth()->id())->pluck('reply_id');
        $replies = Reply::find($likedRepliesID);

        return $replies;
    }
}
