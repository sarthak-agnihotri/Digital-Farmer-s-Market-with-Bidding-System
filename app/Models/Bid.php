<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    //
    protected $fillable = [
        'product_id',
        'user_id',
        'bid_amount'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
