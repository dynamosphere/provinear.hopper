<?php

namespace App\Services\API;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Taggable
{
    public function tags(): MorphToMany;
}
