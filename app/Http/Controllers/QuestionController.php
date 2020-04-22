<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\QuestionRequest;


class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);
    }
                
    public function index()
    {
        return QuestionResource::collection(Question::latest()->get());
    }

    public function store(QuestionRequest $request)
    {
        $request['slug'] = Str::slug($request->title);

        $question = auth()->user()->questions()->create($request->all()); 

        /*$question = Question::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'category_id' => $request->category_id,
            'user_id' => auth()->user()->id
        ]);*/

        return (new QuestionResource($question))->response()->setStatusCode(201);
    }

    public function show(Question $question)
    {
        return new QuestionResource($question);
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $request['slug'] = Str::slug($request->title);

        $question->update($request->all()); //To use request->all(), in the model, add proteced protected $fillable =[title,body...].

        /*$question->update(
            [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'body' => $request->body,
                'category_id' => $request->category_id,
            ]
        );*/ //For this method, in model, only protected $guarded=[] is fine.

        return (new QuestionResource($question))->response()->setStatusCode(202);
    }

    public function destroy(Question $question)
    {
        $question->delete();

		return response('deleted', 204);
    }
}
