<?php

namespace App\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    public function likes(): MorphMany
    {
        return $this->morphMany(
            Like::class,
            'object',
            'object',
            'object_id',
            'like_id'
        );
    }

    public function getLikeCountAttribute(): int
    {
        return $this->likes()->where('liked', true)->count();
    }

    public function getDislikeCountAttribute(): int
    {
        return $this->likes()->where('liked', false)->count();
    }
}
