<?php

namespace App\Models;

use App\Models\Traits\HasUrlTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory, HasUrlTrait;

    protected $fillable = [
        'name',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'sub_category_id');
    }

    protected function getUrlAttribute(): string
    {
        return $this->constructUrl('sub_category');
    }

}
