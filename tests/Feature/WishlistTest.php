<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;

test('consumer can toggle a product in and out of their wishlist', function () {
    // 1. Create a consumer user and a product
    $consumer = User::factory()->create(['role' => 'consumer', 'getting_started_completed' => true]);
    $farmer = User::factory()->create(['role' => 'farmer', 'getting_started_completed' => true]);
    
    $product = Product::create([
        'user_id' => $farmer->id,
        'name' => 'Fresh Apples',
        'category' => 'Fruits',
        'price' => 150,
        'quantity' => 20,
        'status' => 'approved',
    ]);

    // 2. Mock AJAX request to toggle wishlist (add)
    $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    $response = $this->actingAs($consumer)->postJson(route('wishlist.toggle', $product->id));

    // Assert JSON response and database state
    $response->assertStatus(200)
             ->assertJson(['status' => 'added', 'message' => 'Product added to wishlist.']);
    
    $this->assertDatabaseHas('wishlists', [
        'user_id' => $consumer->id,
        'product_id' => $product->id,
    ]);

    // 3. Mock AJAX request to toggle wishlist (remove)
    $response2 = $this->actingAs($consumer)->postJson(route('wishlist.toggle', $product->id));

    // Assert JSON response and database state
    $response2->assertStatus(200)
              ->assertJson(['status' => 'removed', 'message' => 'Product removed from wishlist.']);
    
    $this->assertDatabaseMissing('wishlists', [
        'user_id' => $consumer->id,
        'product_id' => $product->id,
    ]);
});
