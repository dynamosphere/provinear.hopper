<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Currency extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'iso_code';
    protected $table = 'currency';

    protected $fillable = [
        'iso_code',
        'currency_name',
        'basic_unit',
        'symbol',
        'fractional_unit',
        'fractional_to_basic_rate',
        'admin_id',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}
