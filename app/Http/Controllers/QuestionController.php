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
        Question::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'category_id' => $request->category_id,
            'user_id' => auth()->user()->id
        ]);

        return response('Created', 201);
    }

    public function show(Question $question)
    {
        return new QuestionResource($question);
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $question->update(
            [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'body' => $request->body,
                'category_id' => $request->category_id,
            ]
        );

        return response('Updated', 202);
    }

    public function destroy(Question $question)
    {
        $question->delete();
		return response('Deleted', 201);
    }
}
