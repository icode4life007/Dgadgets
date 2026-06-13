<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\OrderTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date') && $request->date != '') {
            switch ($request->date) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }

        $orders = $query->latest()->paginate(15);

        // Statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'delivered')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'totalRevenue'
        ));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,confirmed,packed,shipped,in_transit,out_for_delivery,delivered,cancelled,refunded',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'notify_customer' => 'boolean'
        ]);

        $oldStatus = $order->status;
        $oldPaymentStatus = $order->payment_status;

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

            return redirect()->back()->with('success', 'Order status updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
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
            }

            // If payment status changed from 'paid' to something else, restore stock
            if ($oldPaymentStatus === 'paid' && $request->payment_status !== 'paid') {
                $this->restoreStock($order);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Payment status updated successfully.');

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
                
                \Log::info("Stock reduced for product ID: {$product->id}. New quantity: {$product->quantity}");
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
                
                \Log::info("Stock restored for product ID: {$product->id}. New quantity: {$product->quantity}");
            }
        }
    }

    public function destroy(Order $order)
    {
        DB::beginTransaction();

        try {
            // Restore stock if order was paid before deletion
            if ($order->payment_status === 'paid') {
                $this->restoreStock($order);
            }

            $order->items()->delete();
            $order->trackings()->delete();
            $order->delete();

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting order: ' . $e->getMessage());
        }
    }

    public function bulk(Request $request)
    {
        $request->validate([
            'action' => 'required|in:pending,processing,confirmed,packed,shipped,in_transit,out_for_delivery,delivered,cancelled,refunded,delete',
            'ids' => 'required|array'
        ]);

        DB::beginTransaction();

        try {
            if ($request->action === 'delete') {
                $orders = Order::whereIn('id', $request->ids)->get();
                
                foreach ($orders as $order) {
                    if ($order->payment_status === 'paid') {
                        $this->restoreStock($order);
                    }
                    $order->items()->delete();
                    $order->trackings()->delete();
                    $order->delete();
                }
                
                $message = 'Orders deleted successfully.';
            } else {
                $orders = Order::whereIn('id', $request->ids)->get();
                
                foreach ($orders as $order) {
                    $oldStatus = $order->status;
                    $order->update(['status' => $request->action]);
                    
                    // Create tracking entry for each order
                    OrderTracking::create([
                        'order_id' => $order->id,
                        'status' => $request->action,
                        'location' => 'Bulk update',
                        'description' => 'Order status updated via bulk action',
                        'tracked_at' => now()
                    ]);

                    // Handle stock for cancelled/refunded orders
                    if (in_array($request->action, ['cancelled', 'refunded']) && !in_array($oldStatus, ['cancelled', 'refunded'])) {
                        if ($order->payment_status === 'paid') {
                            $this->restoreStock($order);
                        }
                    }
                }
                
                $message = 'Orders status updated successfully.';
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => $message]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function export(Request $request)
    {
        // Implement CSV export logic
    }
}