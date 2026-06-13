<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    protected $sessionId;
    protected $userId;

    /**
     * Constructor to initialize session and user
     */
    public function __construct()
    {
        $this->sessionId = Session::getId();
        $this->userId = auth()->id();
    }

    /**
     * Display wishlist page
     */
    public function index()
    {
        // Get wishlist items for current user/session
        $wishlist = Wishlist::with(['product' => function($query) {
                $query->with('category');
            }])
            ->forCurrentUser($this->userId, $this->sessionId)
            ->latest()
            ->get();

        // Store count in session for header
        Session::put('wishlist_count', $wishlist->count());

        return view('wishlist', compact('wishlist'));
    }

    /**
     * Add item to wishlist
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid product',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::find($request->product_id);

        try {
            // Check if already in wishlist
            $exists = Wishlist::where('product_id', $product->id)
                ->forCurrentUser($this->userId, $this->sessionId)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is already in your wishlist'
                ]);
            }

            // Add to wishlist
            Wishlist::create([
                'user_id' => $this->userId,
                'product_id' => $product->id,
                'session_id' => $this->userId ? null : $this->sessionId
            ]);

            $count = $this->getWishlistCount();

            // Update session count
            Session::put('wishlist_count', $count);

            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist',
                'count' => $count,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->main_image
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding to wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from wishlist
     */
    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid product',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $deleted = Wishlist::where('product_id', $request->product_id)
                ->forCurrentUser($this->userId, $this->sessionId)
                ->delete();

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in wishlist'
                ]);
            }

            $count = $this->getWishlistCount();

            // Update session count
            Session::put('wishlist_count', $count);

            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'count' => $count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing from wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle wishlist status
     */
    public function toggle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid product',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $exists = Wishlist::where('product_id', $request->product_id)
                ->forCurrentUser($this->userId, $this->sessionId)
                ->exists();

            if ($exists) {
                // Remove from wishlist
                Wishlist::where('product_id', $request->product_id)
                    ->forCurrentUser($this->userId, $this->sessionId)
                    ->delete();
                $added = false;
                $message = 'Product removed from wishlist';
            } else {
                // Add to wishlist
                Wishlist::create([
                    'user_id' => $this->userId,
                    'product_id' => $request->product_id,
                    'session_id' => $this->userId ? null : $this->sessionId
                ]);
                $added = true;
                $message = 'Product added to wishlist';
            }

            $count = $this->getWishlistCount();

            // Update session count
            Session::put('wishlist_count', $count);

            return response()->json([
                'success' => true,
                'message' => $message,
                'added' => $added,
                'count' => $count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error toggling wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if product is in wishlist
     */
    public function check(Request $request, $productId)
    {
        $exists = Wishlist::where('product_id', $productId)
            ->forCurrentUser($this->userId, $this->sessionId)
            ->exists();

        return response()->json([
            'success' => true,
            'in_wishlist' => $exists
        ]);
    }

    /**
     * Get wishlist count
     */
    public function count()
    {
        $count = $this->getWishlistCount();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Clear entire wishlist
     */
    public function clear()
    {
        try {
            Wishlist::forCurrentUser($this->userId, $this->sessionId)
                ->delete();

            Session::put('wishlist_count', 0);

            return response()->json([
                'success' => true,
                'message' => 'Wishlist cleared successfully',
                'count' => 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get multiple products wishlist status
     */
    public function batchCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid product IDs',
                'errors' => $validator->errors()
            ], 422);
        }

        $wishlistItems = Wishlist::whereIn('product_id', $request->product_ids)
            ->forCurrentUser($this->userId, $this->sessionId)
            ->pluck('product_id')
            ->toArray();

        $status = [];
        foreach ($request->product_ids as $productId) {
            $status[$productId] = in_array($productId, $wishlistItems);
        }

        return response()->json([
            'success' => true,
            'status' => $status
        ]);
    }

    /**
     * Get wishlist count for current user/session
     */
    private function getWishlistCount()
    {
        return Wishlist::forCurrentUser($this->userId, $this->sessionId)->count();
    }

    /**
     * Migrate guest wishlist to user (call this after login)
     */
    public function migrate($sessionId, $userId)
    {
        try {
            Wishlist::migrateGuestWishlist($sessionId, $userId);

            return response()->json([
                'success' => true,
                'message' => 'Wishlist migrated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error migrating wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}