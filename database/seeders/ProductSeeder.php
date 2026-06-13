<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $categories = Category::all();
        
        $brands = ['Apple', 'Samsung', 'Nokia', 'Xiaomi', 'OnePlus', 'Google'];
        $models = ['A03', 'A04', 'A05', 'A23', 'A34', 'A55', 'iPhone 11', 'iPhone 12', 'iPhone 13', 'S23', 'S24'];
        
        for ($i = 1; $i <= 50; $i++) {
            $brand = $brands[array_rand($brands)];
            $model = $models[array_rand($models)];
            
            Product::create([
                'name' => $brand . ' ' . $model . ' ' . $faker->word,
                'slug' => $brand . '-' . $model . '-' . $i,
                'category_id' => $categories->random()->id,
                'brand' => $brand,
                'model' => $model,
                'description' => $faker->paragraphs(3, true),
                'price' => $faker->numberBetween(5000, 200000),
                'tax' => $faker->randomElement([0, 5, 7.5, 10]),
                'quantity' => $faker->numberBetween(1, 50),
                'main_image' => 'https://via.placeholder.com/300x300?text=Product+' . $i,
                'gallery_images' => json_encode([
                    'https://via.placeholder.com/300x300?text=Image+1',
                    'https://via.placeholder.com/300x300?text=Image+2',
                    'https://via.placeholder.com/300x300?text=Image+3'
                ]),
                'specifications' => json_encode([
                    'Brand' => $brand,
                    'Model' => $model,
                    'Color' => $faker->colorName,
                    'Storage' => $faker->randomElement(['64GB', '128GB', '256GB']),
                    'RAM' => $faker->randomElement(['4GB', '6GB', '8GB'])
                ]),
                'is_hot_deal' => $faker->boolean(20),
                'is_new_arrival' => $faker->boolean(30),
                'is_featured' => $faker->boolean(15),
                'is_active' => true,
                'views' => $faker->numberBetween(0, 1000),
            ]);
            
            if ($i % 10 == 0) {
                $this->command->info("  ✓ Created {$i} products...");
            }
        }
        
        $this->command->info('✓ Products seeded successfully!');
    }
}