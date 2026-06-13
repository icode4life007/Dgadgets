<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product; // Add this import
use App\Models\OrderItem;
use App\Models\OrderTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Add this import

class OrderController extends Controller
{
    /**
     * Display orders list
     */
    public function index(Request $request)
    {
        $query = Order::with(['items', 'latestTracking']);

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);
        
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count()
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'trackings']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Order::STATUSES)),
            'location' => 'nullable|string|max:255',
            'description' => 'required|string',
            'notify_customer' => 'boolean'
        ]);

        $oldStatus = $order->status;
        
        DB::beginTransaction();

        try {
            $order->status = $request->status;
            
            if ($request->status === 'delivered') {
                $order->delivered_at = now();
            }
            
            $order->save();

            // Create tracking entry
            OrderTracking::create([
                'order_id' => $order->id,
                'status' => $request->status,
                'location' => $request->location,
                'description' => $request->description,
                'tracked_at' => now()
            ]);

            // Handle stock for cancelled/refunded orders
            if (in_array($request->status, ['cancelled', 'refunded']) && !in_array($oldStatus, ['cancelled', 'refunded'])) {
                // Only restore stock if payment was already made
                if ($order->payment_status === 'paid') {
                    $this->restoreStock($order);
                }
            }

            DB::commit();

            // Send WhatsApp notification if enabled
            if ($request->has('notify_customer') && $request->notify_customer) {
                $whatsappLink = $this->sendWhatsAppNotification($order, $oldStatus, $request->status);
                if ($whatsappLink) {
                    session()->flash('whatsapp_link', $whatsappLink);
                }
            }

            return redirect()->back()->with('success', 'Order status updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    /**
     * Update payment status - THIS REDUCES STOCK WHEN PAID
     */
    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:' . implode(',', array_keys(Order::PAYMENT_STATUSES)),
            'payment_method' => 'nullable|string|max:255'
        ]);

        $oldPaymentStatus = $order->payment_status;

        DB::beginTransaction();

        try {
            // Update payment status
            $order->update([
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method
            ]);

            // If payment status changed to 'paid', reduce stock
            if ($oldPaymentStatus !== 'paid' && $request->payment_status === 'paid') {
                $this->reduceStock($order);
                \Log::info("Stock reduced for order #{$order->order_number}");
            }

            // If payment status changed from 'paid' to something else, restore stock
            if ($oldPaymentStatus === 'paid' && $request->payment_status !== 'paid') {
                $this->restoreStock($order);
                \Log::info("Stock restored for order #{$order->order_number}");
            }

            DB::commit();

            return redirect()->back()->with('success', 'Payment status updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating payment: ' . $e->getMessage());
        }
    }

    /**
     * Reduce product stock when order is paid
     */
    private function reduceStock(Order $order)
    {
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            
            if ($product) {
                // Check if enough stock is available
                if ($product->quantity < $item->quantity) {
                    throw new \Exception("Insufficient stock for product: {$product->name}. Available: {$product->quantity}, Requested: {$item->quantity}");
                }

                // Reduce stock
                $product->decrement('quantity', $item->quantity);
                
                \Log::info("Stock reduced for product ID: {$product->id} ({$product->name}). New quantity: {$product->quantity}");
            }
        }
    }

    /**
     * Restore stock when order is cancelled/refunded
     */
    private function restoreStock(Order $order)
    {
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            
            if ($product) {
                // Restore stock
                $product->increment('quantity', $item->quantity);
                
                \Log::info("Stock restored for product ID: {$product->id} ({$product->name}). New quantity: {$product->quantity}");
            }
        }
    }

    /**
     * Update tracking information
     */
    public function updateTracking(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:255',
            'courier_service' => 'nullable|string|max:255',
            'estimated_delivery' => 'nullable|date'
        ]);

        $order->update([
            'tracking_number' => $request->tracking_number,
            'courier_service' => $request->courier_service,
            'estimated_delivery' => $request->estimated_delivery
        ]);

        return redirect()->back()->with('success', 'Tracking information updated');
    }

    /**
     * Add manual tracking update
     */
    public function addTrackingUpdate(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Order::STATUSES)),
            'location' => 'nullable|string|max:255',
            'description' => 'required|string',
            'tracked_at' => 'required|date'
        ]);

        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'location' => $request->location,
            'description' => $request->description,
            'tracked_at' => $request->tracked_at
        ]);

        return redirect()->back()->with('success', 'Tracking update added');
    }

    /**
     * Add admin notes
     */
    public function addNotes(Request $request, Order $order)
    {
        $request->validate([
            'admin_notes' => 'required|string'
        ]);

        $order->update([
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->back()->with('success', 'Notes added successfully');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        DB::beginTransaction();

        try {
            // Restore stock if order was paid before deletion
            if ($order->payment_status === 'paid') {
                $this->restoreStock($order);
            }

            // Delete associated order items first
            $order->items()->delete();
            
            // Delete associated tracking records
            $order->trackings()->delete();
            
            // Delete the order
            $order->delete();

            DB::commit();
            
            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.orders.index')
                ->with('error', 'Error deleting order: ' . $e->getMessage());
        }
    }
    
    /**
 * Delete a tracking entry
 */
public function deleteTracking($trackingId)
{
    try {
        $tracking = OrderTracking::findOrFail($trackingId);
        $orderId = $tracking->order_id;
        $tracking->delete();
        
        // Optional: If this was the latest tracking, update order status
        $order = Order::find($orderId);
        $latestTracking = $order->trackings()->latest('tracked_at')->first();
        
        if ($latestTracking && $order->status !== $latestTracking->status) {
            $order->status = $latestTracking->status;
            $order->save();
        }
        
        return redirect()->back()->with('success', 'Tracking update deleted successfully.');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error deleting tracking update: ' . $e->getMessage());
    }
}

    /**
     * Send WhatsApp notification to customer
     */
    private function sendWhatsAppNotification($order, $oldStatus, $newStatus)
    {
        try {
            // Format phone number
            $phoneNumber = $this->formatPhoneNumber($order->customer_phone);
            
            // Generate WhatsApp message
            $message = $this->generateStatusMessage($order, $oldStatus, $newStatus);
            
            // Encode message for URL
            $encodedMessage = urlencode($message);
            
            // Create WhatsApp URL
            $whatsappUrl = "https://wa.me/{$phoneNumber}?text={$encodedMessage}";
            
            // Log the notification (for debugging)
            \Log::info('WhatsApp notification generated', [
                'order' => $order->order_number,
                'phone' => $phoneNumber,
                'status' => $newStatus
            ]);
            
            return $whatsappUrl;
            
        } catch (\Exception $e) {
            \Log::error('Failed to generate WhatsApp notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Format phone number for WhatsApp
     */
    private function formatPhoneNumber($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If it starts with 0, replace with 234 (Nigeria country code)
        if (substr($phone, 0, 1) === '0') {
            $phone = '234' . substr($phone, 1);
        }
        
        // If it doesn't have country code, add 234
        if (strlen($phone) === 10) {
            $phone = '234' . $phone;
        }
        
        return $phone;
    }

    /**
     * Generate status update message
     */
    private function generateStatusMessage($order, $oldStatus, $newStatus)
    {
        $statusEmojis = [
            'pending' => '⏳',
            'processing' => '🔄',
            'confirmed' => '✅',
            'packed' => '📦',
            'shipped' => '🚚',
            'in_transit' => '🚛',
            'out_for_delivery' => '🚀',
            'delivered' => '🎉',
            'cancelled' => '❌',
            'refunded' => '💰'
        ];

        $statusLabels = Order::STATUSES;
        $oldLabel = $statusLabels[$oldStatus] ?? $oldStatus;
        $newLabel = $statusLabels[$newStatus] ?? $newStatus;
        $emoji = $statusEmojis[$newStatus] ?? '📢';

        $message = "🔔 *DOMINION GADGET & ACCESSORIES - ORDER UPDATE* 🔔\n\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "Hello {$order->customer_name},\n\n";
        $message .= "{$emoji} *Your order status has been updated:*\n\n";
        $message .= "┌─────────────────────\n";
        $message .= "│ Order: #{$order->order_number}\n";
        $message .= "│ From: {$oldLabel}\n";
        $message .= "│ To:   {$newLabel} {$emoji}\n";
        $message .= "└─────────────────────\n\n";
        
        if ($newStatus === 'delivered') {
            $message .= "🎊 *Great news!* Your order has been delivered!\n";
            $message .= "Thank you for shopping with us!\n\n";
        } elseif ($newStatus === 'shipped') {
            $message .= "📦 Your order is on its way!\n\n";
        } elseif ($newStatus === 'cancelled') {
            $message .= "⚠️ Your order has been cancelled.\n";
            $message .= "Please contact us if you have any questions.\n\n";
        } elseif ($newStatus === 'confirmed') {
            $message .= "✅ Your order has been confirmed and is being processed.\n\n";
        }
        
        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "📱 *Track your order:*\n";
        $message .= route('order.track', ['order' => $order->order_number]) . "\n\n";
        $message .= "📞 *Need help?*\n";
        $message .= "WhatsApp: " . config('contact.whatsapp', '2348165987691') . "\n";
        $message .= "Phone: " . config('contact.phone', '+234 703 226 1682') . "\n\n";
        $message .= "🙏 Thank you for choosing Dominion Gadget & Accessories!";
        
        return $message;
    }

    /**
     * Bulk update orders
     */
    public function bulk(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,update_status',
            'orders' => 'required|array',
            'orders.*' => 'exists:orders,id',
            'status' => 'required_if:action,update_status|in:' . implode(',', array_keys(Order::STATUSES))
        ]);

        DB::beginTransaction();

        try {
            if ($request->action === 'delete') {
                $orders = Order::whereIn('id', $request->orders)->get();
                
                foreach ($orders as $order) {
                    if ($order->payment_status === 'paid') {
                        $this->restoreStock($order);
                    }
                    $order->items()->delete();
                    $order->trackings()->delete();
                    $order->delete();
                }
                $message = 'Selected orders deleted successfully.';
            } else {
                $orders = Order::whereIn('id', $request->orders)->get();
                
                foreach ($orders as $order) {
                    $oldStatus = $order->status;
                    $order->update(['status' => $request->status]);
                    
                    // Create tracking entry for each order
                    OrderTracking::create([
                        'order_id' => $order->id,
                        'status' => $request->status,
                        'location' => 'Bulk update',
                        'description' => 'Order status updated via bulk action',
                        'tracked_at' => now()
                    ]);

                    // Handle stock for cancelled/refunded orders
                    if (in_array($request->status, ['cancelled', 'refunded']) && !in_array($oldStatus, ['cancelled', 'refunded'])) {
                        if ($order->payment_status === 'paid') {
                            $this->restoreStock($order);
                        }
                    }
                }
                $message = 'Selected orders status updated successfully.';
            }

            DB::commit();

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error in bulk operation: ' . $e->getMessage());
        }
    }

    /**
     * Export orders
     */
    public function export(Request $request)
    {
        // This is a placeholder for export functionality
        // You can implement CSV/Excel export here
        
        return redirect()->back()->with('info', 'Export feature coming soon!');
    }

    /**
     * Generate invoice
     */
    public function generateInvoice(Order $order)
    {
        // This is a placeholder for invoice generation
        // You can implement PDF invoice here
        
        return redirect()->back()->with('info', 'Invoice generation coming soon!');
    }
}