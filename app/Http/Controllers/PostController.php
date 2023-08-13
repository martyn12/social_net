<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\RepostedResource;
use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
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

        return PostResource::collection($posts);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $image = $data['image'];
        unset($data['image']);
        if ($image) {
            $image_path = md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('/images', $image, $image_path);
            $data['image_path'] = $image_path;
        }
        $data['user_id'] = auth()->id();
        $post = Post::create($data);
        return new PostResource($post);
    }

    public function repost(RepostRequest $request, Post $post)
    {
        $data = $request->validated();

        $data['reposted_id'] = $post->id;
        $data['user_id'] = auth()->id();

        $post = Post::create($data);

        return new PostResource($post);

    }

    public function like(Post $post)
    {
        $likedPosts = auth()->user()->likedPosts()->toggle($post->id);

        $data['is_liked'] = count($likedPosts['attached']) > 0;
        $data['likes'] = $post->likes()->count();

        return $data;
    }

    public function comment(CommentRequest $request, Post $post)
    {
        $data = $request->validated();

        $data['post_id'] = $post->id;
        $data['user_id'] = auth()->id();
        $comment = Comment::create($data);

        return new CommentResource($comment);
    }

    public function getComments(Post $post)
    {
        $comments = $post->comments()->latest()->get();

        return CommentResource::collection($comments);
    }
}
