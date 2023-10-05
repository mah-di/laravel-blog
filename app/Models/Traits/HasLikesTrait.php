<?php

namespace App\Models\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

trait HasLikesTrait
{

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function getLikesCount(): int
    {
        return $this->likes()->count();
    }

    public function isLiked(): bool
    {
        return $this->likes()->where(['user_id' => Auth::user()->id])->exists();
    }

}