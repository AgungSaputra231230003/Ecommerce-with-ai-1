<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

test('public storefront is accessible', function () {
    $response = $this->get('/');

    $response->assertOk();
});

test('customer can register successfully', function () {
    $response = $this->post('/register', [
        'name' => 'Alicia',
        'email' => 'alicia@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/');
    $this->assertDatabaseHas('users', ['email' => 'alicia@example.com', 'role' => 'customer']);
});

test('admin can access dashboard', function () {
    $admin = User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'role' => 'admin',
    ]);

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk();
});

test('customer cannot access admin dashboard', function () {
    $customer = User::factory()->create([
        'name' => 'Customer User',
        'email' => 'customer@example.com',
        'role' => 'customer',
    ]);

    $this->actingAs($customer)
        ->get('/admin')
        ->assertRedirect('/');
});

test('category filter is wired for client-side filtering without reload', function () {
    $response = $this->get('/');

    $response->assertSee('data-ajax-form="true"', false);
    $response->assertSee('data-ajax-target="#products"', false);
    $response->assertSee('id="category-filter"', false);
});

test('adding product to cart via ajax does not trigger a full page reload', function () {
    $user = User::factory()->create();

    $category = Category::create([
        'name' => 'Accessories',
        'slug' => 'accessories',
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'title' => 'Ajax Travel Mug',
        'description' => 'Reusable tumbler for daily carry.',
        'price' => 180000,
        'stock' => 12,
        'image_url' => 'https://example.com/mug.jpg',
    ]);

    $response = $this->actingAs($user)
        ->withHeader('X-Requested-With', 'XMLHttpRequest')
        ->post(route('cart.add', $product));

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('count', 1);
});

test('purchase history stores product images and stays isolated per user', function () {
    $buyer = User::factory()->create();
    $otherUser = User::factory()->create();

    $category = Category::create([
        'name' => 'Accessories',
        'slug' => 'accessories',
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'title' => 'History Glass Bottle',
        'description' => 'Eco bottle with daily carry design.',
        'price' => 220000,
        'stock' => 8,
        'image_url' => 'https://example.com/bottle.jpg',
    ]);

    $this->actingAs($buyer)
        ->withSession(['cart' => [$product->id => 1]])
        ->post(route('checkout'))
        ->assertRedirect(route('cart'));

    $this->assertDatabaseHas('purchase_histories', [
        'user_id' => $buyer->id,
    ]);

    $this->actingAs($buyer)
        ->get('/history')
        ->assertSee('History Glass Bottle')
        ->assertSee('https://example.com/bottle.jpg');

    $this->actingAs($otherUser)
        ->get('/history')
        ->assertDontSee('History Glass Bottle');
});
