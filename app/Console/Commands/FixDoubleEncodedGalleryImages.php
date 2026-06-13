<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class FixDoubleEncodedGalleryImages extends Command
{
    protected $signature = 'fix:gallery-images';
    protected $description = 'Fix double-encoded JSON in gallery_images field';

    public function handle()
    {
        $products = Product::all();
        $fixed = 0;

        foreach ($products as $product) {
            $originalValue = $product->getRawOriginal('gallery_images');
            
            // Skip if null or empty
            if (empty($originalValue)) {
                continue;
            }

            // Case 1: It's a string that looks like double-encoded JSON
            if (is_string($originalValue)) {
                try {
                    // First decode attempt
                    $firstDecode = json_decode($originalValue, true);
                    
                    // If first decode gives us a string, it might be double-encoded
                    if (is_string($firstDecode)) {
                        // Try to decode again
                        $secondDecode = json_decode($firstDecode, true);
                        
                        if (is_array($secondDecode)) {
                            // Success! We got an array after second decode
                            $product->gallery_images = $secondDecode;
                            $product->saveQuietly();
                            $fixed++;
                            $this->info("Fixed product ID: {$product->id} (double decode)");
                        }
                    } 
                    // If first decode already gives us an array, it's fine
                    elseif (is_array($firstDecode)) {
                        $this->info("Product ID: {$product->id} is already correct");
                    }
                } catch (\Exception $e) {
                    $this->error("Error with product ID: {$product->id} - {$e->getMessage()}");
                }
            }
        }

        $this->info("Fixed {$fixed} products with double-encoded gallery images");
    }
}