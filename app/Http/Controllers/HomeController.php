<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        // Get regular categories with their product counts
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('order')
            ->get();

        // Calculate counts for special categories
        $hotDealsCount = Product::where('is_active', true)
            ->where('is_hot_deal', true)
            ->count();

        $newArrivalsCount = Product::where('is_active', true)
            ->where('is_new_arrival', true)
            ->count();

        // Create virtual category objects for Hot Deals and New Arrivals
        $hotDealsCategory = new \stdClass();
        $hotDealsCategory->name = 'Hot Deals';
        $hotDealsCategory->slug = 'hot-deals';
        $hotDealsCategory->icon = 'fas fa-fire';
        $hotDealsCategory->gradient = 'from-red-500 to-orange-500';
        $hotDealsCategory->products_count = $hotDealsCount;

        $newArrivalsCategory = new \stdClass();
        $newArrivalsCategory->name = 'New Arrivals';
        $newArrivalsCategory->slug = 'new-arrivals';
        $newArrivalsCategory->icon = 'fas fa-clock';
        $newArrivalsCategory->gradient = 'from-green-500 to-teal-500';
        $newArrivalsCategory->products_count = $newArrivalsCount;

        // Prepend the virtual categories to the beginning of the collection
        $categories = collect([$hotDealsCategory, $newArrivalsCategory])->merge($categories);

        $hotDealsLimit = setting('hot_deals_limit', 8);
        $newArrivalsLimit = setting('new_arrivals_limit', 8);
        $featuredLimit = setting('featured_limit', 4);

        $hotDeals = Product::where('is_active', true)
            ->where('is_hot_deal', true)
            ->latest()
            ->take($hotDealsLimit)
            ->get();

        $newArrivals = Product::where('is_active', true)
            ->where('is_new_arrival', true)
            ->latest()
            ->take($newArrivalsLimit)
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take($featuredLimit)
            ->get();

        return view('home', compact('categories', 'hotDeals', 'newArrivals', 'featuredProducts'));
    }

    public function category($slug)
    {
        // Handle special "categories" that are actually filters
        if ($slug === 'hot-deals') {
            $products = Product::where('is_active', true)
                ->where('is_hot_deal', true)
                ->latest()
                ->paginate(12);
                
            // Create a virtual category object
            $category = new \stdClass();
            $category->name = 'Hot Deals';
            $category->slug = 'hot-deals';
            $category->icon = 'fas fa-fire';
            $category->description = 'Check out our hottest deals with amazing discounts!';
            
            return view('category', compact('category', 'products'));
        }
        
        if ($slug === 'new-arrivals') {
            $products = Product::where('is_active', true)
                ->where('is_new_arrival', true)
                ->latest()
                ->paginate(12);
                
            // Create a virtual category object
            $category = new \stdClass();
            $category->name = 'New Arrivals';
            $category->slug = 'new-arrivals';
            $category->icon = 'fas fa-clock';
            $category->description = 'Check out our latest products!';
            
            return view('category', compact('category', 'products'));
        }

        // Regular category lookup
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = $category->products()
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('category', compact('category', 'products'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment view count
        $product->increment('views');

        // Get related products from same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        // Get approved reviews for this product - with error handling
        $reviews = collect(); // Empty collection
        try {
            if (Schema::hasTable('reviews')) {
                $reviews = Review::where('product_id', $product->id)
                    ->where('is_approved', true)
                    ->latest()
                    ->paginate(10);
            }
        } catch (\Exception $e) {
            // Log error but don't break the page
            \Log::error('Error fetching reviews: ' . $e->getMessage());
        }

        // Get gallery images - handle both JSON string and array
        $galleryImages = [];
        if ($product->gallery_images) {
            if (is_string($product->gallery_images)) {
                $galleryImages = json_decode($product->gallery_images, true) ?? [];
            } elseif (is_array($product->gallery_images)) {
                $galleryImages = $product->gallery_images;
            }
        }

        // If you want to show pending reviews count for admin users
        $pendingReviewsCount = 0;
        if (auth()->check() && auth()->user() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) {
            try {
                if (Schema::hasTable('reviews')) {
                    $pendingReviewsCount = Review::where('product_id', $product->id)
                        ->where('is_approved', false)
                        ->count();
                }
            } catch (\Exception $e) {
                \Log::error('Error fetching pending reviews: ' . $e->getMessage());
            }
        }

        return view('product', compact(
            'product', 
            'relatedProducts', 
            'reviews',
            'galleryImages',
            'pendingReviewsCount'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $products = Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('brand', 'LIKE', "%{$query}%")
                  ->orWhere('model', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->paginate(12);

        return view('search', compact('products', 'query'));
    }
}