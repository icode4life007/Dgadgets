<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('cart', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);
        
        // Check if quantity is available
        if ($request->quantity > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Requested quantity not available'
            ], 400);
        }

        // Get current cart from session
        $cart = Session::get('cart', []);

        // Add or update quantity
        if (isset($cart[$request->product_id])) {
            $newQuantity = $cart[$request->product_id] + $request->quantity;
            
            // Check if total quantity exceeds stock
            if ($newQuantity > $product->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total quantity exceeds available stock'
                ], 400);
            }
            
            $cart[$request->product_id] = $newQuantity;
        } else {
            $cart[$request->product_id] = $request->quantity;
        }

        // Save cart to session
        Session::put('cart', $cart);

        // Calculate total cart count
        $cartCount = array_sum($cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cartCount' => $cartCount
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart', []);
        $product = Product::find($request->product_id);

        // Check if quantity is available
        if ($request->quantity > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity exceeds available stock'
            ], 400);
        }

        $cart[$request->product_id] = $request->quantity;
        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cartCount' => array_sum($cart)
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = Session::get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cartCount' => array_sum($cart)
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Session::forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
}