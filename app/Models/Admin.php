<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'admin_id';
    protected $table = 'admin';

    protected $fillable = [
        'admin_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }
}
