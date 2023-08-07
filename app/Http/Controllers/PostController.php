<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
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
}
