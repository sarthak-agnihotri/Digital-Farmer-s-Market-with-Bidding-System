<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    //
    public function store(Request $request)
{
    $product = Product::findOrFail($request->product_id);

    Order::create([
        'user_id' => auth()->id(),
        'product_id' => $product->id,
        'quantity' => 1,
        'total_price' => $product->price,
        'status' => 'pending'
    ]);

    return back()->with('success', 'Order placed successfully!');
}
}
