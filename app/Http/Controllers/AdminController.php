<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function __construct()
{
        // Must be logged in
        $this->middleware('auth');

        // Must be admin
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->isAdmin()) {
                abort(403, 'Only Admin can access this page');
            }
            return $next($request);
        });
    }

   public function index()
{
    // show only pending products
    $products = Product::where('status', 'pending')->latest()->get();

    return view('admin.products', compact('products'));
}

    public function approve($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'approved';
        $product->save();

        return back()->with('success', 'Product approved successfully!');
    }
    public function reject($id)
{
    $product = Product::findOrFail($id);
    $product->status = 'rejected';
    $product->save();

    return back()->with('success', 'Product rejected!');
}
}