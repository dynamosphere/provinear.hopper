<?php

namespace App\Models;

use App\Traits\HasFile;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasFactory, HasUuids, HasFile;

    public $incrementing = false;
    public $uploadDir = 'public/shop_brand_images';
    protected $keyType = 'string';
    protected $primaryKey = 'shop_id';
    protected $table = 'shop';

    protected $fillable = [
        'provider_id',
        'shop_name',
        'shop_description',
        'address',
        'brand_logo_url',
        'brand_cover_image_url'
    ];


    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'provider_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'shop_id', 'shop_id');
    }

    public function openingHours(): HasMany
    {
        return $this->hasMany(ShopOpeningHours::class, 'shop_id', 'shop_id');
    }

    public function url(): string
    {
        // To be implemented
        return '';
    }
}
