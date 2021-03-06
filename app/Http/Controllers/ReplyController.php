<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Question;

use Illuminate\Http\Request;
use App\Http\Resources\ReplyResource;
use App\Notifications\ReplyNotification;
use App\Events\RemoveReplyEvent;


class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);
    }
    
    public function index(Question $question)
    {
        return ReplyResource::collection($question->replies);
    }
    
    public function show(Question $question, Reply $reply)
    {
        //
    }
    
    public function store(Question $question, Request $request)
    {   //Stores reply
        $request['user_id'] = auth()->user()->id;

        $reply = $question->replies()->create($request->all());

        //Sends notification
        $user = $question->user;
        
        if($reply->user_id != $question->user_id) {
            $user->notify(new ReplyNotification($reply));
        }
        
        return (new ReplyResource($reply))->response()->setStatusCode(201);
    }
    
    public function update(Question $question, Request $request, Reply $reply)
    {
        $reply->update($request->all());
        
        return (new ReplyResource($reply))->response()->setStatusCode(202);
    }
    
    public function destroy(Question $question,Reply $reply)
    {
        $reply->delete();

        //Makes it live
        broadcast(new RemoveReplyEvent($reply->id))->toOthers();
        
        return response('Deleted', 204);
    }
}
