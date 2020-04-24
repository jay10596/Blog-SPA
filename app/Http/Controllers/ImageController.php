<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }

    public function upload(Request $request)
    {
        auth()->user()->avatar = $request->image;
        auth()->user()->save();

        return response(auth()->user());
    }

    public function remove()
    {
        auth()->user()->avatar = null;
        auth()->user()->save();

        return response(auth()->user());
    }
}
