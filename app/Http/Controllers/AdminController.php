<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;

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

 public function index(Request $request)
{
    $query = Product::with('user');

    // Filters
    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Pagination
    $products = $query->latest()->paginate(6);

    // ✅ STATS
    $totalProducts = Product::count();
    $pendingCount = Product::where('status', 'pending')->count();
    $approvedCount = Product::where('status', 'approved')->count();
    $rejectedCount = Product::where('status', 'rejected')->count();

    return view('admin.products', compact(
        'products',
        'totalProducts',
        'pendingCount',
        'approvedCount',
        'rejectedCount'
    ));
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

    return response()->json(['success' => true]);
}
public function dashboard()
{
    // 💰 Total Revenue
    $totalRevenue = Order::sum('total_price');

    // 📦 Total Orders
    $totalOrders = Order::count();

    // 📊 Revenue for LAST 7 DAYS (Correct Logic ✅)
    $revenueData = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
        ->where('created_at', '>=', now()->subDays(7)) // ✅ FIXED
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

    return view('admin.dashboard', compact(
        'totalRevenue',
        'totalOrders',
        'revenueData'
    ));
}
}