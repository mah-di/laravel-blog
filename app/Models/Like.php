<?php

namespace App\Models;

use App\Models\Traits\HasDateCreatedTrait;
use App\Models\Traits\HasUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{
    use HasFactory, HasUserTrait, HasDateCreatedTrait;

    protected $fillable = [
        'user_id',
        'likable_id',
        'likable_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likable(): MorphTo
    {
        return $this->morphTo();
    }

}
