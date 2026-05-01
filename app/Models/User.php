<?php

namespace App\Models;
use App\Models\Bid;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'getting_started_completed',
        'subscribed_to_product_alerts',
        'preferred_product_categories',
        'preferred_language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'subscribed_to_product_alerts' => 'boolean',
            'preferred_product_categories' => 'array',
        ];
    }

    public function isFarmer() {
    return $this->role === 'farmer';
}

public function isConsumer() {
    return $this->role === 'consumer';
}

public function isAdmin() {
    return $this->role === 'admin';
}

public function hasCompletedGettingStarted() {
    return $this->getting_started_completed;
}
public function bids()
{
    return $this->hasMany(Bid::class);
}

public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}
}