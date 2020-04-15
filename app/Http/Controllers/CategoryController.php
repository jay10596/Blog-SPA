<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryRequest;

use App\Question;
use App\Http\Resources\QuestionResource;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return CategoryResource::collection(Category::latest()->get());
    }

    public function store(CategoryRequest $request)
    {
        $request['slug'] = Str::slug($request->name);
        
        $category = Category::create($request->all());

        return (new CategoryResource($category))->response()->setStatusCode(201); /*It will wrap the content in data: {}

        return response(new CategoryResource($category), 201); it will display content directly because of response()*/
    }

    public function show(Category $category)
    {
        $questions = Question::where('category_id', $category->id)->get();

        return (QuestionResource::collection($questions))->response()->setStatusCode(200);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return (new CategoryResource($category))->response()->setStatusCode(202);
    }

    public function destroy(Category $category)
    {
        $category->delete();

	    return response('Deleted', 204);
    }
}
