<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'rating_id';
    protected $table = 'rating';
    protected $fillable = [
        'object_id',
        'object_type',
        'comment',
        'helpful_upvote_count',
        'helpful_downvote_count'
    ];

}
