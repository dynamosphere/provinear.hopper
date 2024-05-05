<?php

namespace App\Models;

use App\Models\Enums\TaggableObject;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObjectTag extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'object_type_id';
    protected $table = 'object_type';

    protected $fillable = [
        'object_id',
        'tag_id',
        'object_type'
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'tag_id');
    }

    // Todo: Implement a method to get the corresponding object instance based on the object type
}
