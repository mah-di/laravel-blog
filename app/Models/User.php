<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\HasDateCreatedTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasDateCreatedTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'profile_image',
        'email',
        'contact_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    public function totalBlogLikes(): int
    {
        $likesCount = 0;

        foreach ($this->blogs as $blog) {
            $likesCount += $blog->getLikesCount();
        };

        return $likesCount;
    }

    public function getMostLikedBlog(): ?Blog
    {
        $mostLikedBlog = null;

        foreach ($this->blogs as $blog)
        {
            if ($mostLikedBlog == null or $blog->getLikesCount() > $mostLikedBlog->getLikesCount())
            {
                $mostLikedBlog = $blog;
            }
        }

        return $mostLikedBlog;
    }

    public function getMostCommentedBlog(): ?Blog
    {
        $mostCommentedBlog = null;

        foreach ($this->blogs as $blog) 
        {
            if ($mostCommentedBlog == null or $blog->getCommentsCount() > $mostCommentedBlog->getCommentsCount())
            {
                $mostCommentedBlog = $blog;
            }
        }

        return $mostCommentedBlog;
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function totalCommentLikes(): int
    {
        $totalLikes = 0;

        foreach ($this->comments as $comment)
        {
            $totalLikes += $comment->getLikesCount();
        }

        return $totalLikes;
    }

    public function getMostLikedComment(): ?Comment
    {
        $mostLikedComment = null;

        foreach ($this->comments as $comment)
        {
            if ($mostLikedComment == null or $comment->getLikesCount() > $mostLikedComment->getLikesCount())
            {
                $mostLikedComment = $comment;
            }
        }

        return $mostLikedComment;
    }

    public function getMostRepliedComment(): ?Comment
    {
        $mostRepliedComment = null;

        foreach ($this->comments as $comment)
        {
            if ($mostRepliedComment == null and $comment->replies->count() > 0 or $comment->replies->count() > $mostRepliedComment->replies->count())
            {
                $mostRepliedComment = $comment;
            }
        }

        return $mostRepliedComment;
    }

    protected function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    protected function getProfileImageUrlAttribute(): string
    {
        return (strpos($this->profile_image, '://')) ? $this->profile_image : env('APP_URL')."/storage/$this->profile_image";
    }

    public function getBlogsSevenDaysAttribute()
    {
        return $this->blogs->where('created_at', '>', now()->subDays(7)->startOfDay())->get();
    }

    public function getBlogsSevenDaysCountAttribute()
    {
        return $this->blogs->where('created_at', '>', now()->subDays(7)->startOfDay())->count();
    }

    public function getBlogsThirtyDaysAttribute()
    {
        return $this->blogs->where('created_at', '>', now()->subDays(30)->startOfDay())->get();
    }

    public function getBlogsThirtyDaysCountAttribute()
    {
        return $this->blogs->where('created_at', '>', now()->subDays(30)->startOfDay())->count();
    }

}
