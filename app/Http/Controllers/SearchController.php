<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\User;

class SearchController extends Controller
{
    public function getUsers(Request $request)
    {
        $myString = $request->searchTerm;

        $searchResult = User::select()->where('name', 'like', "%$myString%")->get();
            
        return UserResource::collection($searchResult);
    }
}
