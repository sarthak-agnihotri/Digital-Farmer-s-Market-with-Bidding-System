<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// ✅ Product Routes (Already includes index, show, create, etc.)
Route::resource('products', ProductController::class);


// ✅ Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ✅ Auth Protected Routes
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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

    // Bidding
    Route::post('/bids', [BidController::class, 'store'])->name('bids.store');

    // Orders
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

require __DIR__.'/auth.php';