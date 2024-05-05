<?php

namespace App\Models;

use App\Notifications\EmailVerificationNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'user_id';
    protected $table = 'user';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Method to send email verification
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new EmailVerificationNotification());
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(UserContact::class);
    }

    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class, 'user_id', 'user_id');
    }

    public function userKyc(): Hasone
    {
        return $this->hasOne(UserKYC::class, 'user_id', 'user_id');
    }

    public function settings(): HasMany
    {
        return $this->hasMany(UserSetting::class, 'user_id', 'user_id');
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class, 'owner_id', 'user_id');
    }

    public function cart(): HasOne
    {
        return $this->hasOne(UserCart::class, 'cart_id', 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(ProductOrder::class, 'user_id', 'user_id');
    }

    public function billingAddresses(): HasMany
    {
        return $this->hasMany(BillingAddress::class, 'user_id', 'user_id');
    }
}
