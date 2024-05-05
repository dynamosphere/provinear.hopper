<?php

namespace App\Models;

// This model represents the Seller Profile

use App\Traits\HasFile;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Provider extends Model
{
    use HasFactory, HasUuids, HasFile;

    public $incrementing = false;
    public $uploadDir = "public/providers_portraits";
    protected $keyType = 'string';
    protected $primaryKey = 'provider_id';
    protected $table = 'provider';

    protected $fillable = [
        'user_id',
        'portrait_url',
        'badge'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userKYC(): HasOneThrough {
        return $this->hasOneThrough(UserKYC::class, User::class);
    }

    public function isKYCVerified(): bool
    {
        // To be implemented
        return false;
    }

    public function fulfilmentScore(): int
    {
        // To be implemented
        return 100;
    }

    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class, 'provider_id');
    }

    public function contacts(): HasManyThrough
    {
        return $this->hasManyThrough(UserContact::class, User::class);
    }
}
