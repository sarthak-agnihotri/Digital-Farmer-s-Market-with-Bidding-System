<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GettingStartedController;
use Illuminate\Support\Facades\Route;

Route::middleware('set.locale')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

// ✅ Logout Success Page
Route::get('/logout-success', function () {
    return view('auth.logout-success');
})->name('logout.success');


// ✅ Product Routes (Already includes index, show, create, etc.)
Route::resource('products', ProductController::class);


// ✅ Dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->isConsumer()) {
        return redirect()->route('consumer.dashboard');
    }

    // Default to Farmer's dashboard
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/api/dashboard-stats', function () {
    $user = auth()->user();

    if (!$user->isFarmer()) {
        return response()->json([], 403);
    }

    $userProducts = \App\Models\Product::where('user_id', $user->id);

    return response()->json([
        'total_products' => $userProducts->count(),
        'approved_products' => $userProducts->where('status', 'approved')->count(),
        'pending_products' => $userProducts->where('status', 'pending')->count(),
        'rejected_products' => $userProducts->where('status', 'rejected')->count(),
        'open_bids' => \App\Models\Bid::whereIn('product_id', $userProducts->pluck('id'))->count(),
    ]);
})->middleware(['auth', 'verified'])->name('api.dashboard-stats');

Route::get('/dashboard/stats', function () {
    $user = auth()->user();

    $stats = [
        'totalProducts' => \App\Models\Product::count(),
        'openBids' => \App\Models\Bid::count(),
        'pendingProducts' => \App\Models\Product::where('status', 'pending')->count(),
        'productsByCategory' => \App\Models\Product::select('category')
            ->selectRaw('count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category'),
        'recentProducts' => \App\Models\Product::where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as day, count(*) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day'),
    ];

    return response()->json($stats);
})->middleware(['auth', 'verified'])->name('dashboard.stats');


// ✅ Auth Protected Routes
Route::middleware(['auth', 'check.getting.started'])->group(function () {

    // Getting Started Routes
    Route::get('/getting-started', [GettingStartedController::class, 'index'])->name('getting-started');
    Route::post('/getting-started/complete', [GettingStartedController::class, 'complete'])->name('getting-started.complete');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Real-time notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
    Route::post('/notifications/mark-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // Admin
    Route::get('/admin/products', [AdminController::class, 'index'])->name('admin.products');
    Route::post('/admin/products/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Consumer
    Route::get('/consumer/dashboard', function () {
        return view('consumer.dashboard');
    })->name('consumer.dashboard');

    Route::get('/consumer/bids', [BidController::class, 'myBids'])->name('consumer.bids');

    // Wishlist
    Route::get('/consumer/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('consumer.wishlist');
    Route::post('/wishlist/{product}/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Bidding
    Route::post('/bids', [BidController::class, 'store'])->name('bids.store');

    // Orders
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

Route::get('/locale/{locale}', [App\Http\Controllers\LocaleController::class, 'switch'])
    ->middleware('auth')
    ->name('locale.switch');
});

require __DIR__.'/auth.php';