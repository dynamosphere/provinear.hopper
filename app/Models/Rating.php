<?php

namespace App\Models;

use App\Traits\HasLikes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory, HasUuids, HasLikes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'rating_id';
    protected $table = 'rating';
    protected $fillable = [
        'object_id',
        'object_type',
        'comment',
        'rate',
        'user_id',
        'parent_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Rating::class, 'parent_id', 'rating_id');
    }

}
