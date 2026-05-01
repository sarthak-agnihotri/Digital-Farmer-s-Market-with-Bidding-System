<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bid;
use App\Models\User;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'price',
        'quantity',
        'is_bidding',
        'buy_now_price',
        'bidding_end_time',
        'status',
        'image'
    ];

    // ✅ Product belongs to a User (Farmer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Product has many bids
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    // ✅ Product can be wishlisted by many users
    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class);
    }
}