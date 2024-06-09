<?php

namespace App\Models;

use App\Casts\JsonCast;
use App\Casts\MoneyCast;
use App\Models\Enums\LikeableObject;
use App\Models\Enums\RateableObject;
use App\Models\Enums\TaggableObject;
use App\Services\API\Likable;
use App\Services\API\Rateable;
use App\Services\API\Taggable;
use App\Traits\HasLikes;
use App\Traits\HasRatings;
use App\Traits\HasTags;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Product extends Model implements Likable, Rateable, Taggable
{
    use HasFactory, HasUuids, HasTags, HasLikes, HasRatings;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'product_id';
    protected $table = 'product';

    protected $fillable = [
        'shop_id',
        'product_name',
        'product_description',
        'brand_name',
        'product_attribute',
        'product_status',
        'available_quantity',
        'unit_price',
        'currency_code',
        'strikeout_price',
        'price_percentage_discount',
        'approval_status',
        'approved_by',
        'approval_comment',
        'opened_to_bargain',
        'estimated_prepare_minute',
        'unit_measure'
    ];

    protected $casts = [
        'unit_price'                => MoneyCast::class,
        'strikeout_price'           => MoneyCast::class,
        'price_percentage_discount' => 'decimal:2',
        'product_attribute'         => JsonCast::class,
        'opened_to_bargain'         => 'boolean'
    ];
    public static string $morph_type_name = TaggableObject::PRODUCT->value;
    public static TaggableObject $tag_type = TaggableObject::PRODUCT;
    public static LikeableObject $like_type = LikeableObject::PRODUCT;
    public static RateableObject $rate_type = RateableObject::PRODUCT;

    public function shop(): BelongsTo
    {
        return $this->belongsTo('shop', 'shop_id', 'shop_id');
    }

    public function provider(): HasOneThrough
    {
        return $this->hasOneThrough(Provider::class, Shop::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id', 'product_id', 'category_id');
    }

    public function quantityDiscounts(): HasMany
    {
        return $this->hasMany(ProductQuantityDiscount::class, 'product_id', 'product_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'iso_code');
    }

    public function variationsType(): HasManyThrough
    {
        return $this->hasManyThrough(Variation::class, ProductVariation::class, 'product_id', 'variation_id', 'product_id', 'variation_id');
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'product_id', 'product_id');
    }
}
