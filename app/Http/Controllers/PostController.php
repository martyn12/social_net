<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $image = $data['image'];
        if ($image) {
            $image_path = md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('/images', $image, $image_path);
            unset($data['image']);
            $data['image_path'] = $image_path;
        }
        $data['user_id'] = auth()->id();
        Post::create($data);
        return response()->json(['message' => 'post has been stored']);
    }
}
