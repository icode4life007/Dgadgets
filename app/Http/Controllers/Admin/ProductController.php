<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('brand', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::where('is_active', true)->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'main_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['main_image', 'gallery_images']);

        // Set boolean flags
        $data['is_hot_deal'] = $request->has('is_hot_deal') ? 1 : 0;
        $data['is_new_arrival'] = $request->has('is_new_arrival') ? 1 : 0;
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_active'] = true;
        $data['tax'] = $request->tax ?? 0;
        
        // Generate slug from name
        $data['slug'] = Str::slug($request->name);
        
        // Check if slug exists and make it unique
        $count = Product::where('slug', 'like', $data['slug'] . '%')->count();
        if ($count > 0) {
            $data['slug'] = $data['slug'] . '-' . ($count + 1);
        }

        // Create upload directory if it doesn't exist
        $uploadPath = public_path('uploads/products');
        $galleryPath = public_path('uploads/products/gallery');
        
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        if (!file_exists($galleryPath)) {
            mkdir($galleryPath, 0777, true);
        }

        // Handle main image
        if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
            $image = $request->file('main_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Move the uploaded file
            $image->move($uploadPath, $filename);
            $data['main_image'] = 'uploads/products/' . $filename;
        } else {
            return back()->withErrors(['main_image' => 'Please select a valid image file.'])->withInput();
        }

        // Create the product
        $product = Product::create($data);

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $index => $image) {
                if ($image->isValid()) {
                    $filename = time() . '_' . $index . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($galleryPath, $filename);
                    $gallery[] = 'uploads/products/gallery/' . $filename;
                }
            }
            // Set gallery images - the model's mutator will handle encoding
            $product->gallery_images = $gallery;
            $product->save();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load('category');
        
        // No need to decode - the model's accessor already returns an array
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        
        // No need to decode - the model's accessor already returns an array
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $product->id . '|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['main_image', 'gallery_images']);

        // Set boolean flags
        $data['is_hot_deal'] = $request->has('is_hot_deal');
        $data['is_new_arrival'] = $request->has('is_new_arrival');
        $data['is_featured'] = $request->has('is_featured');
        $data['tax'] = $request->tax ?? 0;

        // Update slug if name changed
        if ($product->name !== $request->name) {
            $slug = Str::slug($request->name);
            $count = Product::where('slug', 'like', $slug . '%')->where('id', '!=', $product->id)->count();
            $data['slug'] = $count > 0 ? $slug . '-' . ($count + 1) : $slug;
        }

        // Create upload directory if it doesn't exist
        $uploadPath = public_path('uploads/products');
        $galleryPath = public_path('uploads/products/gallery');
        
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        if (!file_exists($galleryPath)) {
            mkdir($galleryPath, 0777, true);
        }

        // Handle main image
        if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
            // Delete old image
            if ($product->main_image && file_exists(public_path($product->main_image))) {
                unlink(public_path($product->main_image));
            }

            $image = $request->file('main_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($uploadPath, $filename);
            $data['main_image'] = 'uploads/products/' . $filename;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images - use the model's helper method
            $oldGallery = $product->getSafeGalleryImages();
            
            if (is_array($oldGallery) && count($oldGallery) > 0) {
                foreach ($oldGallery as $oldImage) {
                    $oldImagePath = public_path($oldImage);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }

            // Upload new gallery images
            $gallery = [];
            foreach ($request->file('gallery_images') as $index => $image) {
                if ($image->isValid()) {
                    $filename = time() . '_' . $index . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($galleryPath, $filename);
                    $gallery[] = 'uploads/products/gallery/' . $filename;
                }
            }
            // Set gallery images - the model's mutator will handle encoding
            $data['gallery_images'] = $gallery;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Delete main image
            if ($product->main_image && file_exists(public_path($product->main_image))) {
                unlink(public_path($product->main_image));
            }

            // Delete gallery images - use the model's helper method
            $gallery = $product->getSafeGalleryImages();
            
            if (is_array($gallery) && count($gallery) > 0) {
                foreach ($gallery as $image) {
                    $imagePath = public_path($image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }

            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $product->is_active ? 'active' : 'inactive',
                'message' => 'Product status updated successfully.'
            ]);
        }
        
        return redirect()->back()
            ->with('success', 'Product status updated successfully.');
    }

    /**
     * Bulk delete products.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id'
        ]);

        try {
            foreach ($request->ids as $id) {
                $product = Product::find($id);
                if ($product) {
                    // Delete main image
                    if ($product->main_image && file_exists(public_path($product->main_image))) {
                        unlink(public_path($product->main_image));
                    }
                    
                    // Delete gallery images - use the model's helper method
                    $gallery = $product->getSafeGalleryImages();
                    
                    if (is_array($gallery) && count($gallery) > 0) {
                        foreach ($gallery as $image) {
                            $imagePath = public_path($image);
                            if (file_exists($imagePath)) {
                                unlink($imagePath);
                            }
                        }
                    }
                    
                    $product->delete();
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' products deleted successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting products: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export products to CSV.
     */
    public function export()
    {
        $products = Product::with('category')->get();
        
        $filename = 'products_' . date('Y-m-d_His') . '.csv';
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Add headers
        fputcsv($handle, ['ID', 'Name', 'Category', 'Brand', 'Model', 'Price', 'Tax', 'Quantity', 'Status', 'Hot Deal', 'New Arrival', 'Featured', 'Created At']);
        
        // Add data
        foreach ($products as $product) {
            fputcsv($handle, [
                $product->id,
                $product->name,
                $product->category->name,
                $product->brand,
                $product->model,
                $product->price,
                $product->tax,
                $product->quantity,
                $product->is_active ? 'Active' : 'Inactive',
                $product->is_hot_deal ? 'Yes' : 'No',
                $product->is_new_arrival ? 'Yes' : 'No',
                $product->is_featured ? 'Yes' : 'No',
                $product->created_at->format('Y-m-d H:i:s')
            ]);
        }
        
        fclose($handle);
        exit;
    }
}