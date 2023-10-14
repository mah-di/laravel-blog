<?php

namespace App\Models;

use App\Models\Traits\HasUrlTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUrlTrait;

    protected $fillable = [
        'name',
    ];

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    protected function getUrlAttribute(): string
    {
        return $this->constructUrl('category');
    }

}
