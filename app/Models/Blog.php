<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'cover_image',
        'category_id',
        'sub_category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
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
        $preview = str_split($this->body, 20)[0];

        return (strlen($this->body) > 20) ? "$preview.." : $preview;
    }

    protected function getCoverImageUrlAttribute(): string
    {
        return env('APP_URL')."/storage/$this->cover_image";
    }

    protected function getDateCreatedAttribute(): string
    {
        return date('d M Y', strtotime($this->created_at));
    }
}