<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bid;
class Product extends Model
{
    //
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
        'image',
    ];
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
