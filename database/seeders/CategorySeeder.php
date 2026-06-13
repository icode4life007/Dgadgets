<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Hot Deals',
                'slug' => 'hot-deals',
                'description' => 'Limited time offers with amazing discounts',
                'icon' => 'fas fa-fire',
                'gradient' => 'from-red-500 to-orange-500',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'New Arrivals',
                'slug' => 'new-arrivals',
                'description' => 'Latest gadgets just arrived',
                'icon' => 'fas fa-clock',
                'gradient' => 'from-green-500 to-emerald-500',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'description' => 'Latest mobile phones from top brands',
                'icon' => 'fas fa-mobile-alt',
                'gradient' => 'from-blue-500 to-cyan-500',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'High-performance laptops for work and play',
                'icon' => 'fas fa-laptop',
                'gradient' => 'from-yellow-500 to-amber-500',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Tablets',
                'slug' => 'tablets',
                'description' => 'Portable tablets for entertainment and productivity',
                'icon' => 'fas fa-tablet-alt',
                'gradient' => 'from-pink-500 to-rose-500',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Gaming consoles and accessories',
                'icon' => 'fas fa-gamepad',
                'gradient' => 'from-purple-500 to-indigo-500',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Phone cases, chargers, and more',
                'icon' => 'fas fa-headphones',
                'gradient' => 'from-teal-500 to-cyan-500',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Smart Watches',
                'slug' => 'smart-watches',
                'description' => 'Wearable tech for fitness and connectivity',
                'icon' => 'fas fa-clock',
                'gradient' => 'from-indigo-500 to-purple-500',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Audio',
                'slug' => 'audio',
                'description' => 'Headphones, earbuds, and speakers',
                'icon' => 'fas fa-headphones',
                'gradient' => 'from-red-500 to-pink-500',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'Deals',
                'slug' => 'deals',
                'description' => 'Special offers and discounts',
                'icon' => 'fas fa-tags',
                'gradient' => 'from-orange-500 to-red-500',
                'order' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✓ Categories seeded successfully');
    }
}