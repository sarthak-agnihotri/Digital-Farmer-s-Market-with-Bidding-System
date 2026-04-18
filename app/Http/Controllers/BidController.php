<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BidController extends Controller
{
    //
public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'bid_amount' => 'required|numeric|min:1'
    ]);

    $product = \App\Models\Product::findOrFail($request->product_id);

    // 🔥 NEW: Check bidding time
    if ($product->bidding_end_time && now()->greaterThan($product->bidding_end_time)) {
        return back()->with('error', 'Bidding has ended for this product!');
    }

    // Get highest bid
    $highestBid = $product->bids()->max('bid_amount');

    // If no bids yet, use product price
    $minBid = $highestBid ?? $product->price;

    // Check condition
    if ($request->bid_amount <= $minBid) {
        return back()->with('error', 'Bid must be greater than current highest bid!');
    }

    \App\Models\Bid::create([
        'product_id' => $product->id,
        'user_id' => auth()->id(),
        'bid_amount' => $request->bid_amount
    ]);

    return back()->with('success', 'Bid placed successfully!');
}

public function myBids()
{
    $bids = \App\Models\Bid::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

    return view('consumer.bids', compact('bids'));
}
}
