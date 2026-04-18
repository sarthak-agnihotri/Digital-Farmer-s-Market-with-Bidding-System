<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/products-list',[ProductController::class,'index'])->name('products.index');
    Route::get('/admin/products',[AdminController::class,'index'])->name('admin.products');
    Route::post('/admin/products/{id}/approve',[AdminController::class,'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});
Route::get('/consumer/dashboard', function () {
    return view('consumer.dashboard');
})->middleware('auth')->name('consumer.dashboard');
Route::get('/consumer/bids', [App\Http\Controllers\BidController::class, 'myBids'])
    ->middleware('auth')
    ->name('consumer.bids');
Route::post('/bids',[BidController::class,'store'])->name('bids.store');
require __DIR__.'/auth.php';
