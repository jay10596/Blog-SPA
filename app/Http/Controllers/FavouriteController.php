<?php

namespace App\Http\Controllers;

use App\Favourite;
use App\Question;

use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Events\FavouriteEvent;


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
    {   //Adds Favourite
        $question->favourites()->create([ 
            'user_id' => auth()-> id(),
        ]);

        //Makes it live
        broadcast(new FavouriteEvent($question->slug, 1))->toOthers();
    }

    public function unfavouriteIt(Question $question)
    {   //Removes Favourite
        $question->favourites()->where('user_id', auth()->id())->first()->delete();
    
        //Makes it live
        broadcast(new FavouriteEvent($question->slug, 0))->toOthers();
    }
}
