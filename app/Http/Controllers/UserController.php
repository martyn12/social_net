<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNot('id', auth()->id())->get();

        return UserResource::collection($users);
    }

    public function getName(User $user)
    {
        return response()->json($user->name);
    }

    public function post(User $user)
    {
        $posts = $user->posts()->orderBy('updated_at', 'DESC')->get();
        return PostResource::collection($posts);
    }
}
