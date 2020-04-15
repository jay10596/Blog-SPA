<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;


class UserController extends Controller
{

    public function index()
    {
        return User::latest()->get();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(UserRequest $request, User $user)
    {
        auth()->user()->update($request->all());

        return response('Updated', 202);
    }

    public function destroy(User $user)
    {
        auth()->user()->delete();

        return response('Deleted', 201);
    }
}
