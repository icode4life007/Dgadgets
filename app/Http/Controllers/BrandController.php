<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Product::select('brand')
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->distinct()
            ->orderBy('brand')
            ->get()
            ->pluck('brand');
            
        return view('brands', compact('brands'));
    }

    public function show($slug)
    {
        // Convert slug back to brand name (e.g., "apple" -> "Apple")
        $brand = str_replace('-', ' ', $slug);
        $brand = ucwords($brand); // Capitalize each word
        
        // Get products for this brand
        $products = Product::where('brand', $brand)
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
            
        return view('brand-products', compact('brand', 'products', 'slug'));
    }
}