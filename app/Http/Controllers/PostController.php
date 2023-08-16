<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    protected $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $posts = $this->service->index();

        return PostResource::collection($posts);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $post = $this->service->store($data);

        return new PostResource($post);
    }

    public function repost(RepostRequest $request, Post $post)
    {
        $data = $request->validated();
        $post = $this->service->repost($data, $post);

        return new PostResource($post);

    }

    public function like(Post $post)
    {
        return $this->service->like($post);
    }

    public function comment(CommentRequest $request, Post $post)
    {
        $data = $request->validated();
        $comment = $this->service->comment($data, $post);

        return new CommentResource($comment);
    }

    public function getComments(Post $post)
    {
        $comments = $this->service->getComments($post);

        return CommentResource::collection($comments);
    }
}
