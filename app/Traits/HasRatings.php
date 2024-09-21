<?php

namespace App\Traits;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasRatings
{
    public function ratings(): MorphMany
    {
        return $this->morphMany(
            Rating::class,
            'object',
            'object',
            'object_id',
            'rating_id'
        );
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->average('rate');
    }

}
