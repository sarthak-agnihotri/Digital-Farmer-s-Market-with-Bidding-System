<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;

// Create dummy data
$farmer = User::firstOrCreate(['email' => 'farmer_test_wishlist@example.com'], [
    'name' => 'Farmer',
    'role' => 'farmer',
    'password' => bcrypt('password'),
    'getting_started_completed' => true
]);

$consumer = User::firstOrCreate(['email' => 'consumer_test_wishlist@example.com'], [
    'name' => 'Consumer',
    'role' => 'consumer',
    'password' => bcrypt('password'),
    'getting_started_completed' => true
]);

$product = Product::firstOrCreate(['name' => 'Wishlist Test Product'], [
    'user_id' => $farmer->id,
    'category' => 'Fruits',
    'price' => 100,
    'quantity' => 10,
    'status' => 'approved'
]);

// 1. Simulate adding to wishlist
$request = \Illuminate\Http\Request::create("/wishlist/{$product->id}/toggle", 'POST');
$request->headers->set('Accept', 'application/json');

// Login as consumer manually
auth()->login($consumer);

// Invoke controller method directly to test logic
$controller = app()->make(\App\Http\Controllers\WishlistController::class);
$response = $controller->toggle($request, $product);

echo "Toggle 1 (Add): " . $response->getContent() . "\n";

// 2. Simulate removing from wishlist
$response2 = $controller->toggle($request, $product);
echo "Toggle 2 (Remove): " . $response2->getContent() . "\n";
