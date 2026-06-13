<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTracking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show checkout form
     */
    public function index()
    {
        // Get cart items from session
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;
        $itemCount = 0;

        foreach ($cart as $id => $quantity) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
                $itemCount += $quantity;
            }
        }

        // If cart is empty, redirect back to cart
        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }

        return view('checkout', compact('cartItems', 'total', 'itemCount'));
    }

    /**
     * Process checkout and generate WhatsApp URL
     */
    public function process(Request $request)
    {
        // Use database transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'email' => 'nullable|email|max:255',
                'notes' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please fill in all required fields',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get cart items
            $cart = Session::get('cart', []);
            $cartItems = [];
            $total = 0;
            $itemCount = 0;

            foreach ($cart as $id => $quantity) {
                // Lock the product row to prevent race conditions
                $product = Product::lockForUpdate()->find($id);
                
                if (!$product) {
                    throw new \Exception("Product not found: ID {$id}");
                }

                // Check if enough stock is available
                if ($product->quantity < $quantity) {
                    throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->quantity}, Requested: {$quantity}");
                }

                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
                $itemCount += $quantity;
            }

            if (empty($cartItems)) {
                throw new \Exception('Your cart is empty');
            }

            // Generate unique order number
            $orderNumber = 'DOM-' . strtoupper(uniqid()) . '-' . date('Ymd');

            // Create order in database
            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_name' => $request->full_name,
                'customer_phone' => $request->phone,
                'customer_email' => $request->email ?? '',
                'customer_address' => $request->address,
                'shipping_address' => $request->address,
                'notes' => $request->notes,
                'subtotal' => $total,
                'total' => $total,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => null,
                'tracking_number' => null,
                'courier_service' => null,
                'estimated_delivery' => null,
                'delivered_at' => null,
                'admin_notes' => null
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'product_image' => $item['product']->main_image,
                    'price' => $item['product']->price,
                    'quantity' => $item['quantity'],
                    'total' => $item['subtotal']
                ]);
            }

            // Create initial tracking entry
            OrderTracking::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'location' => 'Order Received',
                'description' => 'Your order has been received and is awaiting confirmation.',
                'tracked_at' => now()
            ]);

            // Commit the transaction
            DB::commit();

            // Get WhatsApp number from config or use default
            $whatsappNumber = config('contact.whatsapp', '2348165987691');
            
            // Generate WhatsApp message
            $message = $this->generateWhatsAppMessage($order, $cartItems, $total, $itemCount, $request);
            $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($message);

            // Store order in session for confirmation page
            Session::put('last_order', [
                'order' => $order,
                'items' => $cartItems,
                'total' => $total,
                'customer' => [
                    'name' => $request->full_name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'email' => $request->email,
                    'notes' => $request->notes
                ]
            ]);

            // Clear cart after successful order
            Session::forget('cart');

            return response()->json([
                'success' => true,
                'whatsapp_url' => $whatsappUrl,
                'redirect_url' => route('order.confirmation', ['order' => $order->order_number])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show order confirmation page
     */
    public function confirmation($orderNumber = null)
    {
        // If order number is provided, get from database
        if ($orderNumber) {
            $order = Order::where('order_number', $orderNumber)
                ->with(['items', 'trackings'])
                ->first();
                
            if ($order) {
                return view('order-confirmation', compact('order'));
            }
        }
        
        // Fallback to session data
        $lastOrder = Session::get('last_order');
        
        if (!$lastOrder) {
            return redirect()->route('home');
        }
        
        return view('order-confirmation', ['order' => $lastOrder['order'] ?? null, 'lastOrder' => $lastOrder]);
    }

    /**
     * Generate WhatsApp message with order details and customer information
     */
    private function generateWhatsAppMessage($order, $cartItems, $total, $itemCount, $request)
    {
        $message = "🛍️ *NEW ORDER - DOMINION GADGET & ACCESSORIES* 🛍️\n\n";
        
        $message .= "━━━━━ *ORDER DETAILS* ━━━━━\n\n";
        
        foreach ($cartItems as $item) {
            $product = $item['product'];
            
            $message .= "📦 *Product:* {$product->name}\n";
            $message .= "🔢 *Quantity:* {$item['quantity']}\n";
            $message .= "💰 *Price:* ₦" . number_format($product->price, 0) . "\n";
            $message .= "💵 *Subtotal:* ₦" . number_format($item['subtotal'], 0) . "\n\n";
        }
        
        $message .= "━━━━━ *SUMMARY* ━━━━━\n";
        $message .= "📦 *Total Items:* {$itemCount}\n";
        $message .= "💰 *Subtotal:* ₦" . number_format($total, 0) . "\n";
        $message .= "🚚 *Delivery Fee:* To be calculated\n";
        $message .= "💎 *TOTAL AMOUNT: ₦" . number_format($total, 0) . "*\n\n";
        
        $message .= "━━━━━ *CUSTOMER INFORMATION* ━━━━━\n";
        $message .= "👤 *Name:* {$request->full_name}\n";
        $message .= "📞 *Phone:* {$request->phone}\n";
        $message .= "📍 *Address:* {$request->address}\n";
        
        if ($request->email) {
            $message .= "📧 *Email:* {$request->email}\n";
        }
        
        if ($request->notes) {
            $message .= "📝 *Notes:* {$request->notes}\n";
        }
        
        $message .= "\n━━━━━ *TRACKING* ━━━━━\n";
        $message .= "🔗 *Track your order:* " . route('order.track', ['order' => $order->order_number]) . "\n";
        $message .= "📋 *Order #:* {$order->order_number}\n\n";
        
        $message .= "━━━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "🤝 One of our sales representatives will contact you shortly to confirm your order and provide payment details.\n\n";
        $message .= "🙏 *Thank you for shopping with Dominion Gadget & Accessories!* 🙏";
        
        return $message;
    }

    /**
     * Show order review page
     */
    public function review()
    {
        // Get cart items from session
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;
        $itemCount = 0;

        foreach ($cart as $id => $quantity) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
                $itemCount += $quantity;
            }
        }

        // If cart is empty, redirect back to cart
        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }

        return view('checkout-review', compact('cartItems', 'total', 'itemCount'));
    }
}