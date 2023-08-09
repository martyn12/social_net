<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNot('id', auth()->id())->get();
        $followingIds = SubscriberFollowing::where('subscriber_id', auth()->id())->get('following_id')
            ->pluck('following_id')->toArray();

        foreach ($users as $user) {
            if (in_array($user->id, $followingIds)) {
                $user->is_followed = true;
            }
        }

        return UserResource::collection($users);
    }

    public function follow(User $user)
    {
       $followed_user = auth()->user()->followed()->toggle($user->id);

       $data['is_followed'] = count($followed_user['attached']) > 0;

       return $data;
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
