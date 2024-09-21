<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{

    public function tags(): MorphToMany
    {
        return $this->morphToMany(
            Tag::class,
            'object',
            'object_tag',
            'object_id',
            'tag_id',
            $this->primaryKey,
            'tag_id'
        );
    }

//    public function getMorphClass()
//    {
//        return $this->morph_type_name;
//    }
}
