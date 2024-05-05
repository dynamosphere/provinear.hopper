<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'category_id';
    protected $table = 'category';

    protected $fillable = [
        'category_name',
        'category_description'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->using(ProductCategory::class);
    }
}
