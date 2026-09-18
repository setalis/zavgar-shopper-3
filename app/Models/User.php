<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Shopper\Models\Contracts\ShopperUser;
use Shopper\Traits\InteractsWithShopper;

#[Fillable(['first_name', 'last_name', 'email', 'password', 'phone_number'])]
#[Hidden(['password', 'remember_token', 'store_two_factor_secret', 'store_two_factor_recovery_codes'])]
class User extends Authenticatable implements ShopperUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, InteractsWithShopper, Notifiable;

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
}
