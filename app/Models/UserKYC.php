<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserKYC extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'kcy_registration_id';
    protected $table = 'user_kyc';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'address',
        'city',
        'postal_code',
        'verification_option_id',
        'identity_number',
        'identity_card_front_image_url',
        'identity_card_back_image_url',
        'status',
        'customer_image_url'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function verificationOption(): BelongsTo
    {
        return $this->belongsTo(KycVerificationOption::class, 'verification_option_id', 'verification_option_id');
    }
}
