<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\CategoryResource;


class CategoryController extends Controller
{

    public function index()
    {
        return CategoryResource::collection(Category::latest()->get());
    }

    public function store(Request $request)
    {
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response('Created', 201);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response('Updated', 202);
    }

    public function destroy(Category $category)
    {
        $category->delete();
	    return response('Deleted', 201);
    }
}
