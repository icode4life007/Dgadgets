<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('🔄 Starting database seeding...');
        $this->command->line('----------------------------------------');
        
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables in correct order
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('admins')->truncate();
        
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('✓ Tables truncated successfully');
        $this->command->line('----------------------------------------');
        
        // Run seeders
        $this->call(CategorySeeder::class);
        $this->call(AdminSeeder::class);
        // Uncomment the line below if you want sample products
        // $this->call(ProductSeeder::class);
        
        $this->command->line('----------------------------------------');
        $this->command->info('✅ Database seeded successfully!');
        
        // Show summary
        $this->command->table(
            ['Table', 'Records'],
            [
                ['categories', \App\Models\Category::count()],
                ['admins', \App\Models\Admin::count()],
                ['products', \App\Models\Product::count()],
            ]
        );
    }
}