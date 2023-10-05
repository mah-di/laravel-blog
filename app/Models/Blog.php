<?php

namespace App\Models;

use App\Models\Traits\HasDateCreatedTrait;
use App\Models\Traits\HasLikesTrait;
use App\Models\Traits\HasUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, HasDateCreatedTrait, HasUserTrait, HasLikesTrait;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'cover_image',
        'category_id',
        'sub_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_id')->whereNull('parent_id');
    }

    public function getCommentsCount(): int
    {
        return Comment::where('blog_id', $this->id)->count();
    }

    public static function fetchBlogs($limit = 10, $where = null)
    {
        if ($where !== null) {

            return self::latest()->take($limit)->where($where)->get();

        }

        return self::latest()->take($limit)->get();
    }

    protected function getTitleUpperAttribute(): string
    {
        return strtoupper($this->title);
    }

    protected function getBodyPreviewAttribute(): string
    {
        $preview = substr($this->body, 0, 20);

        return (strlen($this->body) > 20) ? "$preview.." : $preview;
    }

    protected function getCoverImageUrlAttribute(): string
    {
        return env('APP_URL')."/storage/$this->cover_image";
    }

}
