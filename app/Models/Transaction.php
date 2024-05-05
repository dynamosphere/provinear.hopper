<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'transaction_id';
    protected $table = 'transaction';

    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'payment_detail',
        'status'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(ProductOrder::class, 'order_id', 'order_id');
    }
}
