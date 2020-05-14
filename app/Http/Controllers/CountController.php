<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\ReplyResource;

use App\Category;
use App\Question;
use App\Reply;

class CountController extends Controller
{
    public function maxReplies(Request $request) 
    {
        $slug = $request->slug;

        $question = Question::where('slug', $slug)->get();
        
        return ReplyResource::collection($question[0]->replies)->groupBy('user_id');
    }

    public function maxQuestions(Request $request)
    {
        $slug = $request->slug;

        $category = Category::where('slug', $slug)->get();
        
        return QuestionResource::collection($category[0]->questions)->groupBy('user_id');
    }

    public function thisMonthQuestions(Request $request) 
    {
        return QuestionResource::collection(Question::whereRaw('created_at like "%-' . now()->format('m') . '-%"')->paginate(5)); //Or use get();
    }
}
