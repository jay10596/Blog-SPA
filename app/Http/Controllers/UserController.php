<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return User::latest()->get();
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());

        return (new UserResource($user))->response()->setStatusCode(202);
    }

    public function destroy(User $user)
    {
        auth()->user()->delete();

        return response('Deleted', 204);
    }
}
