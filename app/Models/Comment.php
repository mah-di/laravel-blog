<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id',
        'blog_id',
        'parent_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    protected function getDateCreatedAttribute(): string
    {
        return date('d M Y', strtotime($this->created_at));
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function isLiked(): bool
    {
        return $this->likes()->where(['user_id' => Auth::user()->id])->exists();
    }

    public function getLikesCount(): int
    {
        return $this->likes()->count();
    }

}
