<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('prevents adding more items than available stock', function () {
    $user = User::factory()->create(['role' => 'customer']);
    $category = Category::create(['name' => 'Test Category', 'slug' => 'test-category']);
    $product = Product::create([
        'category_id' => $category->id,
        'title' => 'Limited Item',
        'description' => 'Stock limited product',
        'price' => 150000,
        'stock' => 2,
        'image_url' => 'https://example.com/image.jpg',
    ]);

    $this->actingAs($user)
        ->withSession(['cart' => [$product->id => 2]])
        ->post(route('cart.add', $product))
        ->assertSessionHas('error')
        ->assertRedirect();
});

it('rejects checkout when cart exceeds current stock', function () {
    $user = User::factory()->create(['role' => 'customer']);
    $category = Category::create(['name' => 'Checkout Test', 'slug' => 'checkout-test']);
    $product = Product::create([
        'category_id' => $category->id,
        'title' => 'Stock Check Product',
        'description' => 'Cannot checkout beyond stock',
        'price' => 200000,
        'stock' => 1,
        'image_url' => 'https://example.com/checkout.jpg',
    ]);

    $this->actingAs($user)
        ->withSession(['cart' => [$product->id => 2]])
        ->post(route('checkout'))
        ->assertSessionHas('error', 'Stok produk ' . $product->title . ' tidak mencukupi untuk checkout.')
        ->assertRedirect(route('cart'));
});
