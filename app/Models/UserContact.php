<?php

namespace App\Models;

use App\Models\Enums\TaggableObject;
use App\Traits\HasTags;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class UserContact extends Model
{
    use HasFactory, HasUuids, HasTags;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'contact_id';
    protected $table = 'user_contact';
    protected $fillable = [
        'user_id',
        'type',
        'contact',
        'provider'
    ];

    public static string $morph_type_name = TaggableObject::CONTACT->value;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function provider(): HasOneThrough
    {
        return $this->hasOneThrough(Provider::class, User::class);
    }

}
