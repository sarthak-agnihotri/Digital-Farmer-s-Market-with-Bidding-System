<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Product::query();
        //only show approved products
        $query->where('status', 'approved');
        // 🔍 Search by name
        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        //filter by category
        if($request->category){
            $query->where('category', $request->category);
        }
        //filter by min price
         if ($request->price) {
        $query->where('price', '<=', $request->price);
        }
       $products = $query->with('bids.user')->latest()->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if(!auth()->check()||!auth()->user()->isFarmer()){
            abort(403, 'Unauthorized action.');
        }
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // check farmer
    if (!auth()->check() || !auth()->user()->isFarmer()) {
        abort(403, 'Unauthorized action.');
    }

    // validation
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:1',
        'is_bidding' => 'nullable',
        'buy_now_price' => 'nullable|numeric|min:0',
        'bidding_end_time' => 'nullable|date',

        // ✅ NEW
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ HANDLE IMAGE
    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

    // store data
    \App\Models\Product::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'category' => $request->category,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'is_bidding' => $request->has('is_bidding'),
        'buy_now_price' => $request->buy_now_price,
        'bidding_end_time' => $request->bidding_end_time,
        'status' => 'pending',

        // ✅ SAVE IMAGE
        'image' => $imagePath,
    ]);

    return redirect()->route('dashboard')->with('success', 'Product created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
{
    // Load bids + user (important for bidding history)
    $product->load('bids.user');

    return view('products.show', compact('product'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Check if user is authenticated and is a farmer
        if (!auth()->check() || !auth()->user()->isFarmer()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if product belongs to authenticated user
        if ($product->user_id !== auth()->id()) {
            abort(403, 'You cannot edit this product.');
        }

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Check if user is authenticated and is a farmer
        if (!auth()->check() || !auth()->user()->isFarmer()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if product belongs to authenticated user
        if ($product->user_id !== auth()->id()) {
            abort(403, 'You cannot update this product.');
        }

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'is_bidding' => 'nullable',
            'buy_now_price' => 'nullable|numeric|min:0',
            'bidding_end_time' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle image upload
        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Update product
        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'is_bidding' => $request->has('is_bidding'),
            'buy_now_price' => $request->buy_now_price,
            'bidding_end_time' => $request->bidding_end_time,
            'image' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Check if user is authenticated and is a farmer
        if (!auth()->check() || !auth()->user()->isFarmer()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if product belongs to authenticated user
        if ($product->user_id !== auth()->id()) {
            abort(403, 'You cannot delete this product.');
        }

        // Delete image if exists
        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }

        // Delete product
        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Product deleted successfully.');
    }
}
