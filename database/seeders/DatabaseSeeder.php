<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@novacart.test',
            'role' => 'admin',
        ]);

        $categories = [
            ['name' => 'Streetwear', 'slug' => 'streetwear'],
            ['name' => 'Skincare', 'slug' => 'skincare'],
            ['name' => 'Tech', 'slug' => 'tech'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $catalogByCategory = [
            'streetwear' => [
                'Nova Oversize Tee',
                'Vanta Layered Hoodie',
                'Neon Drop Bomber',
                'Concrete Cargo Pants',
                'Pixel Graphic Tee',
                'Rivet Zip Hoodie',
                'Metro Utility Jacket',
                'Nox Canvas Overshirt',
                'Orbit Knit Polo',
                'Echo Track Jacket',
                'Velvet Leather Vest',
                'Dune Street Crew',
                'Cinder Denim Layer',
                'Summit Zip Fleece',
                'Monarch Work Shirt',
                'Drift Windbreaker',
                'Blur Street Hoodie',
                'Prime Cargo Jogger',
                'Northline Quarter Zip',
                'Luna Graphic Hoodie',
                'Apex Utility Vest',
                'Signal Oversized Tee',
                'Stoneline Bomber',
                'Night Fade Sweatshirt',
                'Harbor Street Shirt',
                'Vapor Ribbed Tee',
                'Coast Denim Jacket',
                'Brass Street Cap',
                'Flow Canvas Pant',
                'Aster Knit Hoodie',
                'Midnight Track Set',
            ],
            'skincare' => [
                'Glow Serum',
                'Dew Mist Essence',
                'Velvet Cleanser',
                'Cloud Cream',
                'Bloom Night Mask',
                'Satin Eye Roll-On',
                'Hydra Dew Gel',
                'Velvet Barrier Lotion',
                'Pure Bright Toner',
                'Moon Silk Essence',
                'Nourish Repair Oil',
                'Sun Veil SPF',
                'Fresh Reset Mist',
                'Glow Boost Peel',
                'Calm Cloud Serum',
                'Rose Dew Cleanser',
                'Petal Soft Cream',
                'Daily Bright Toner',
                'Skin Shield Oil',
                'Citrus Hydration Mist',
                'Balance Daily Essence',
                'Radiant Renewal Gel',
                'Silk Barrier Cream',
                'Night Recovery Elixir',
                'Soft Touch Cleanser',
                'Moonlit Glow Mask',
                'Dew Lift Serum',
                'Fresh Calm Toner',
                'Glow Recovery Balm',
                'Ultra Hydration Lotion',
                'Smooth Velvet Mist',
            ],
            'tech' => [
                'Pulse Wireless Buds',
                'Aero Smartwatch',
                'Nova Mini Speaker',
                'Luma USB-C Dock',
                'Orbit Watch Pro',
                'Echo Sound Bar',
                'Volt Fast Charger',
                'Pixel Pro Earbuds',
                'Zenith Smart Band',
                'Mirror Display Hub',
                'Arc Wireless Mouse',
                'Beam Compact Projector',
                'Halo Smart Lamp',
                'Core Bluetooth Speaker',
                'Drift Gaming Pad',
                'Nexa Laptop Stand',
                'Studio Audio Kit',
                'Live Wireless Mic',
                'Signal USB Hub',
                'Flex USB-C Cable',
                'Summit Power Bank',
                'Frame Smart Display',
                'AirCast Dongle',
                'Nova Portable SSD',
                'Tune Noise Canceller',
                'Motion Fitness Watch',
                'Pioneer Laptop Sleeve',
                'Nexa Mini Camera',
                'Trail Smart Tracker',
                'Raft Wireless Charger',
                'Crest Bluetooth Headset',
            ],
            'accessories' => [
                'Orbit Mini Backpack',
                'Prism Sunglasses',
                'Drift Cap',
                'Drift Tote Bag',
                'Horizon Sling Bag',
                'Luma Travel Pouch',
                'Nova Crossbody',
                'Velvet Key Holder',
                'Aero Bottle Flask',
                'Tide Everyday Tote',
                'Curve Zip Wallet',
                'Lattice Sunglasses',
                'Metro Weekender',
                'Fjord Leather Belt',
                'Pace Running Cap',
                'Zen Canvas Bag',
                'North Carry Case',
                'Bloom Cosmetic Pouch',
                'Summit Utility Sling',
                'Vanta Card Holder',
                'Drift Travel Set',
                'Halo Visor',
                'Signal Duffle',
                'Arc Wristlet',
                'Terra Lunch Tote',
                'Nova Sport Sling',
                'Monarch Leather Wallet',
                'Strata Headband',
                'Streetline Satchel',
                'Glide Everyday Pack',
                'Orbit Mini Case',
            ],
        ];

        $imagePoolByCategory = [
            'streetwear' => [
                'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=900&q=80',
            ],
            'skincare' => [
                'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1556228578-8c89e6adf883?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=900&q=80',
            ],
            'tech' => [
                'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1518444065439-e933c06ce9cd?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=80',
            ],
            'accessories' => [
                'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1521369909026-2afed882baee?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=900&q=80',
            ],
        ];

        foreach ($catalogByCategory as $slug => $titles) {
            $categoryId = Category::where('slug', $slug)->value('id');

            foreach ($titles as $index => $title) {
                $price = match ($slug) {
                    'streetwear' => 210000 + ($index * 17000),
                    'skincare' => 120000 + ($index * 11000),
                    'tech' => 320000 + ($index * 23000),
                    'accessories' => 110000 + ($index * 14000),
                    default => 100000,
                };

                Product::create([
                    'category_id' => $categoryId,
                    'title' => $title,
                    'description' => ucfirst($slug) . ' essentials built for comfort, style, and everyday use.',
                    'price' => $price,
                    'stock' => 8 + (($index * 3) % 22),
                    'image_url' => $imagePoolByCategory[$slug][$index % count($imagePoolByCategory[$slug])],
                ]);
            }
        }
    }
}
