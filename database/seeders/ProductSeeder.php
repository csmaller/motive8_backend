<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'M8 Team Racing Tri Suit',
                'description' => 'Professional-grade triathlon suit designed for optimal performance. Features moisture-wicking fabric, aerodynamic fit, and quick-dry technology.',
                'price' => 149.99,
                'original_price' => 179.99,
                'category' => 'apparel',
                'images' => ['/api/placeholder/400/400'],
                'in_stock' => true,
                'stock_quantity' => 25,
                'sizes' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                'colors' => ['Navy/Orange', 'Black/Blue'],
                'rating' => 4.8,
                'review_count' => 42,
                'features' => [
                    'Moisture-wicking fabric',
                    'Aerodynamic design',
                    'Quick-dry technology',
                    'Compression fit'
                ],
                'brand' => 'M8 Team',
                'payment_link' => 'http://square.com/test'
            ],
            [
                'name' => 'Pro Cycling Jersey',
                'description' => 'High-performance cycling jersey with advanced ventilation and reflective elements for safety. Perfect for long rides and competitive racing.',
                'price' => 89.99,
                'original_price' => 119.99,
                'category' => 'apparel',
                'images' => ['/api/placeholder/400/400'],
                'in_stock' => true,
                'stock_quantity' => 40,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Red/White', 'Blue/Black', 'Green/Yellow'],
                'rating' => 4.6,
                'review_count' => 28,
                'features' => [
                    'Advanced ventilation',
                    'Reflective elements',
                    'Three rear pockets',
                    'Full-length zipper'
                ],
                'brand' => 'M8 Team',
                'payment_link' => 'http://square.com/test2'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
