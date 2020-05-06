<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ReplyResource;

use App\Question;
use App\Reply;

class CountController extends Controller
{
    public function maxReplies(Request $request) {
        $slug = $request->slug;

        $question = Question::where('slug', $slug)->get();
        
        return  ReplyResource::collection($question[0]->replies)->groupBy('user_id');
    }
}
