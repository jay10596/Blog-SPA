<?php

namespace App\Http\Controllers;

use App\Favourite;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;


class FavouriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }

    public function getQuestions()
    {
        $likedQuestionsID = Favourite::where('user_id', auth()->id())->pluck('question_id');
        $questions = Question::find($likedQuestionsID);

        return QuestionResource::collection($questions);
    }
    
    public function favouriteIt(Question $question)
    {
        $question->favourites()->create([ 
            'user_id' => auth()-> id(),
        ]);
    }

    public function unfavouriteIt(Question $question)
    {
        $question->favourites()->where('user_id', auth()->id())->first()->delete();
    }
}
