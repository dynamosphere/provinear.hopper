<?php

namespace App\Models;

use App\Models\Enums\ProductApprovalStatus;
use App\Models\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Product extends Model
{
    use HasFactory, HasUuids;

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
        return $this->belongsToMany(Category::class)->using(ProductCategory::class);
    }

    public function quantityDiscounts(): HasMany
    {
        return $this->hasMany(ProductQuantityDiscount::class, 'product_id', 'product_id');
    }
}
