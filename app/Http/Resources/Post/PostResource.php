<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'id' => $this->id,
            'content' => $this->content,
            'image' => $this->image,
            'date' => $this->date,
            'is_liked' => $this->is_liked ?? false,
            'likes' => $this->likes->count()
        ];
    }
}
