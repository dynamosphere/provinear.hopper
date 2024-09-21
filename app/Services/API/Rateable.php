<?php

namespace App\Services\API;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Rateable
{
    public function ratings(): MorphMany;
    public function getAverageRatingAttribute();
}
