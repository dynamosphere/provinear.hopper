<?php

namespace App\Models;

use App\Models\Enums\TaggableObject;
use App\Services\API\Taggable;
use App\Traits\HasTags;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model implements Taggable
{
    use HasFactory, HasUuids, HasTags;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'category_id';
    protected $table = 'category';

    protected $fillable = [
        'category_name',
        'category_description',
        'parent_id',
        'owner_id'
    ];

    public static string $morph_type_name = TaggableObject::CATEGORY->value;
    public static TaggableObject $tag_type = TaggableObject::CATEGORY;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id', 'category_id', 'product_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'category_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'user_id');
    }
}
