<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * Show tracking page
     */
    public function index(Request $request)
    {
        $order = null;
        $trackings = null;
        
        if ($request->has('order')) {
            $order = Order::where('order_number', $request->order)
                ->with(['items', 'trackings'])
                ->first();
                
            if ($order) {
                $trackings = $order->trackings;
            }
        }
        
        return view('tracking', compact('order', 'trackings'));
    }

    /**
     * Track order by number
     */
    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string'
        ]);

        return redirect()->route('order.track', ['order' => $request->order_number]);
    }

    /**
     * Show tracking API for AJAX
     */
    public function apiTrack($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items', 'trackings'])
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => [
                'number' => $order->order_number,
                'status' => $order->status,
                'status_text' => Order::STATUSES[$order->status],
                'progress' => $order->progress_percentage,
                'estimated_delivery' => $order->estimated_delivery ? $order->estimated_delivery->format('M d, Y') : null,
                'delivered_at' => $order->delivered_at ? $order->delivered_at->format('M d, Y H:i') : null,
                'tracking_number' => $order->tracking_number,
                'courier_service' => $order->courier_service,
                'trackings' => $order->trackings->map(function($tracking) {
                    return [
                        'status' => $tracking->status,
                        'status_text' => Order::STATUSES[$tracking->status],
                        'location' => $tracking->location,
                        'description' => $tracking->description,
                        'tracked_at' => $tracking->tracked_at->format('M d, Y H:i')
                    ];
                })
            ]
        ]);
    }
}