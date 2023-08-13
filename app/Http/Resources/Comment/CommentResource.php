<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        $parent = isset($this->parent) ?? null;
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => new UserResource($this->user),
            'post_id' => $this->post_id,
            'date' => $this->date,
            'parent' => $this->parent ?? null
        ];
    }
}
