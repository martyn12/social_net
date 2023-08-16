<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StatRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = $this->service->index();

        return UserResource::collection($users);
    }

    public function follow(User $user)
    {
        return $this->service->follow($user);
    }

    public function getName(User $user)
    {
        return response()->json($user->name);
    }

    public function post(User $user)
    {
        $posts = $this->service->post($user);
        return PostResource::collection($posts);
    }

    public function feed()
    {
        $posts = $this->service->feed();

        return PostResource::collection($posts);
    }

    public function stat(StatRequest $request)
    {
        $data = $request->validated();
        $resp = $this->service->stat($data);

        return response()->json(['data' => $resp]);
    }
}
