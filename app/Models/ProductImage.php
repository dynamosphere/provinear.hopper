<?php

namespace App\Models;

use App\Models\Enums\TaggableObject;
use App\Traits\HasFile;
use App\Traits\HasTags;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ProductImage extends Model
{
    use HasFactory, HasUuids, HasFile, HasTags;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'product_image_id';
    protected $table = 'product_image';

    protected $fillable = [
        'product_id',
        'image_url'
    ];

    public static string $morph_type_name = TaggableObject::PRODUCT_IMAGE->value;

    public static TaggableObject $tag_type = TaggableObject::PRODUCT_IMAGE;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

//    public function tags(): MorphToMany
//    {
//        return $this->morphToMany(Tag::class, 'object', 'object_tag', 'object_id', 'tag_id', 'product_image_id', 'tag_id', 'object_tag_id');
//    }
}
