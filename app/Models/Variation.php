<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Variation extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'variation_id';
    protected $table = 'variation';

    protected $fillable = [
        'name',
        'description',
        'owner_id'
    ];

    public function product_variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'variation_id', 'variation_id');
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, ProductVariation::class, 'variation_id', 'product_id', 'variation_id', 'product_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'user_id');
    }
}
