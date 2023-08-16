<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->latest()->get();
        $likedPostsIds = LikedPost::where('user_id', auth()->id())->get('post_id')->pluck('post_id')->toArray();
        foreach ($posts as $post) {
            if (in_array($post->id, $likedPostsIds)) {
                $post->is_liked = true;
            }
        }
        return $posts;
    }

    public function store($data)
    {
        $image = $data['image'];
        unset($data['image']);
        if ($image) {
            $image_path = md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('/images', $image, $image_path);
            $data['image_path'] = $image_path;
        }
        $data['user_id'] = auth()->id();

        return Post::create($data);
    }

    public function repost($data, Post $post)
    {
        $data['reposted_id'] = $post->id;
        $data['user_id'] = auth()->id();

        return Post::create($data);

    }

    public function like(Post $post)
    {
        $likedPosts = auth()->user()->likedPosts()->toggle($post->id);
        $data['is_liked'] = count($likedPosts['attached']) > 0;
        $data['likes'] = $post->likes()->count();

        return $data;
    }

    public function comment($data, Post $post)
    {
        $data['post_id'] = $post->id;
        $data['user_id'] = auth()->id();
        return Comment::create($data);
    }

    public function getComments(Post $post)
    {
        return $post->comments()->latest()->get();
    }

}
