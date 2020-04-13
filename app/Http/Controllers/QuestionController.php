<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\QuestionResource;


class QuestionController extends Controller
{
    public function index()
    {
        return QuestionResource::collection(Question::latest()->get());
    }

    public function store(Request $request)
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

    public function update(Request $request, Question $question)
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
