<?php

namespace App\Models;

use App\Models\Traits\HasDateCreatedTrait;
use App\Models\Traits\HasLikesTrait;
use App\Models\Traits\HasUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasDateCreatedTrait, HasUserTrait, HasLikesTrait;

    protected $fillable = [
        'body',
        'user_id',
        'blog_id',
        'parent_id',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

}
