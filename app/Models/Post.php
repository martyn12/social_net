<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $with = ['likes', 'comments'];

    public function getImageAttribute()
    {
        $image_path = $this->image_path ?? null;

        if ($image_path) {
            return url('/storage/images/' . $image_path);
        }
        else return null;
    }

    public function getDateAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    public function likes()
    {
        return $this->hasMany(LikedPost::class, 'post_id', 'id');
    }

    public function repostedPost()
    {
        return $this->belongsTo(Post::class, 'reposted_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
