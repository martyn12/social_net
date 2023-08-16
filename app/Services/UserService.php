<?php

namespace App\Services;

use App\Models\LikedPost;
use App\Models\Post;
use App\Models\SubscriberFollowing;
use App\Models\User;

class UserService
{
    public function index()
    {
        $users = User::whereNot('id', auth()->id())->get();
        $followingIds = $this->getFollowingIds();

        foreach ($users as $user) {
            if (in_array($user->id, $followingIds)) {
                $user->is_followed = true;
            }
        }

        return $users;
    }

    public function follow(User $user)
    {
        $followingUser = auth()->user()->followed()->toggle($user->id);

        $data['is_followed'] = count($followingUser['attached']) > 0;

        return $data;
    }

    public function getName(User $user)
    {
        return response()->json($user->name);
    }

    public function post(User $user)
    {
        $posts = $user->posts()->orderBy('updated_at', 'DESC')->get();

        $this->checkPostIsLiked($posts);
        return $posts;
    }

    public function feed()
    {
        $followingIds = $this->getFollowingIds();
        $likedPostsIds = $this->getLikedPostsIds();

        $posts = Post::whereIn('user_id', $followingIds)->whereNotIn('id', $likedPostsIds)->latest()->get();

        return $posts;
    }

    public function checkPostIsLiked($posts)
    {
        $likedPostsIds = $this->getLikedPostsIds();

        foreach ($posts as $post) {
            if (in_array($post->id, $likedPostsIds)) {
                $post->is_liked = true;
            }
        }

        return $posts;
    }

    public function getFollowingIds()
    {
        return SubscriberFollowing::where('subscriber_id', auth()->id())->get('following_id')
            ->pluck('following_id')->toArray();
    }

    public function getLikedPostsIds()
    {
        return LikedPost::where('user_id', auth()->id())->get('post_id')->pluck('post_id')->toArray();
    }

    public function stat($data)
    {
        $userId = isset($data['user_id']) ? $data['user_id'] : auth()->id();
        $resp = [];
        $postsIds = Post::where('user_id', $userId)->get('id')->pluck('id')->toArray();
        $resp['likes_count'] = LikedPost::whereIn('post_id', $postsIds)->count();
        $resp['subscribers_count'] = SubscriberFollowing::where('following_id', $userId)->count();
        $resp['follows_count'] = SubscriberFollowing::where('subscriber_id', $userId)->count();
        $resp['posts_count'] = count($postsIds);

        return $resp;
    }
}
