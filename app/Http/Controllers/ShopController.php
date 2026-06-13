<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Get all active categories for filter
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get unique brands/tags from products
        $tags = Product::where('is_active', true)
            ->select('brand', 'model')
            ->get()
            ->flatMap(function ($product) {
                return [$product->brand, $product->model];
            })
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // Get price range for filter
        $minPrice = Product::where('is_active', true)->min('price') ?? 0;
        $maxPrice = Product::where('is_active', true)->max('price') ?? 100000;

        // Build query with filters
        $query = Product::where('is_active', true);

        // Handle filter parameter for hot deals and new arrivals
        if ($request->has('filter')) {
            if ($request->filter === 'hot-deals') {
                $query->where('is_hot_deal', true);
            } elseif ($request->filter === 'new-arrivals') {
                $query->where('is_new_arrival', true);
            }
        }

        // Apply category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Apply price filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Apply tag filter
        if ($request->filled('tag')) {
            $query->where(function ($q) use ($request) {
                $q->where('brand', 'LIKE', "%{$request->tag}%")
                  ->orWhere('model', 'LIKE', "%{$request->tag}%");
            });
        }

        // Apply search filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('description', 'LIKE', "%{$request->search}%")
                  ->orWhere('brand', 'LIKE', "%{$request->search}%")
                  ->orWhere('model', 'LIKE', "%{$request->search}%");
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'default');
        switch ($sortBy) {
            case 'popularity':
                $query->orderBy('views', 'desc');
                break;
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Get products with pagination
        $products = $query->paginate(12)->withQueryString();

        // Get total products count
        $totalProducts = Product::where('is_active', true)->count();

        return view('shop', compact(
            'categories',
            'tags',
            'products',
            'totalProducts',
            'minPrice',
            'maxPrice'
        ));
    }

    public function filterByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        return redirect()->route('shop', ['category' => $slug]);
    }

    public function filterByTag($tag)
    {
        return redirect()->route('shop', ['tag' => $tag]);
    }
}