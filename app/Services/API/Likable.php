<?php

namespace App\Services\API;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Likable
{
    public function likes(): MorphMany;
    public function getLikeCountAttribute();
    public function getDislikeCountAttribute();
}
