<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Resources\ReplyResource;

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
        return new ReplyResource($reply);
    }
    
    public function store(Question $question, Request $request)
    {
        $reply = Reply::create([
            'body' => $request->body,
            'question_id' => $question->id,
            'user_id' =>auth()->user()->id,
        ]);

        return response(['reply' => new ReplyResource($reply)], 201);
    }
    
    public function update(Question $question, Request $request, Reply $reply)
    {
        $reply->update($request->all());
        
        return response('Updated', 202);
    }
    
    public function destroy(Question $question,Reply $reply)
    {
        $reply->delete();
        
        return response('Deleted', 201);
    }
}
