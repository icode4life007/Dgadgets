<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Constructor to share data with admin layout
     */
    public function __construct()
    {
        // Share notification data with all admin views
        view()->composer('admin.layouts.admin', function ($view) {
            try {
                $pendingOrdersCount = Order::where('status', 'pending')->count();
                
                // Get recent orders with customer details
                $recentOrders = Order::select('id', 'order_number', 'customer_name', 'total_amount', 'status', 'created_at')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function($order) {
                        return (object)[
                            'id' => $order->id,
                            'order_number' => $order->order_number,
                            'customer_name' => $order->customer_name,
                            'message' => "New order #{$order->order_number} from {$order->customer_name}",
                            'amount' => $order->total_amount,
                            'status' => $order->status,
                            'created_at' => $order->created_at,
                            'time' => $order->created_at->diffForHumans()
                        ];
                    });
                
                $view->with([
                    'pendingOrdersCount' => $pendingOrdersCount,
                    'recentOrders' => $recentOrders
                ]);
            } catch (\Exception $e) {
                // If orders table doesn't exist yet, pass empty data
                $view->with([
                    'pendingOrdersCount' => 0,
                    'recentOrders' => collect([])
                ]);
            }
        });
    }

    /**
     * Display the dashboard
     */
    public function index()
    {
        try {
            // Product stats
            $totalProducts = Product::count();
            $activeProducts = Product::where('is_active', true)->count();
            $totalCategories = Category::count();
            $totalViews = Product::sum('views');
            
            // Review stats
            $totalReviews = Review::count();
            $pendingReviews = Review::where('is_approved', false)
                ->whereNull('rejected_at')
                ->count();
            
            // Order stats
            $totalOrders = Order::count();
            $todayOrders = Order::whereDate('created_at', today())->count();
            $pendingOrders = Order::where('status', 'pending')->count();
            $processingOrders = Order::where('status', 'processing')->count();
            $completedOrders = Order::where('status', 'completed')->count();
            $cancelledOrders = Order::where('status', 'cancelled')->count();
            $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
            
            // Recent data
            $recentProducts = Product::with('category')
                ->latest()
                ->take(5)
                ->get();
            
            $recentOrders = Order::with('items')
                ->latest()
                ->take(5)
                ->get();
            
            $pendingReviewsList = Review::with('product')
                ->where('is_approved', false)
                ->whereNull('rejected_at')
                ->latest()
                ->take(5)
                ->get();

            // Add average rating to recent products
            foreach ($recentProducts as $product) {
                $product->average_rating = $product->reviews()
                    ->where('is_approved', true)
                    ->avg('rating') ?? 0;
            }

            // Calculate percentage changes (compare with previous period)
            $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)->count();
            $orderGrowth = $lastMonthOrders > 0 ? round((($totalOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1) : 0;
            
            $lastMonthRevenue = Order::whereMonth('created_at', now()->subMonth()->month)
                ->where('status', 'completed')
                ->sum('total_amount');
            $revenueGrowth = $lastMonthRevenue > 0 ? round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 0;

            return view('admin.dashboard', compact(
                'totalProducts',
                'activeProducts',
                'totalCategories',
                'totalViews',
                'totalReviews',
                'pendingReviews',
                'totalOrders',
                'todayOrders',
                'pendingOrders',
                'processingOrders',
                'completedOrders',
                'cancelledOrders',
                'totalRevenue',
                'recentProducts',
                'recentOrders',
                'pendingReviewsList',
                'orderGrowth',
                'revenueGrowth'
            ));

        } catch (\Exception $e) {
            // If any tables don't exist yet, return empty data
            return view('admin.dashboard', $this->getEmptyDashboardData());
        }
    }

    /**
     * Get dashboard stats for AJAX requests
     */
    public function getStats()
    {
        try {
            $stats = [
                'totalProducts' => Product::count(),
                'activeProducts' => Product::where('is_active', true)->count(),
                'totalCategories' => Category::count(),
                'totalViews' => Product::sum('views'),
                'totalReviews' => Review::count(),
                'pendingReviews' => Review::where('is_approved', false)
                    ->whereNull('rejected_at')
                    ->count(),
                'totalOrders' => Order::count(),
                'todayOrders' => Order::whereDate('created_at', today())->count(),
                'pendingOrders' => Order::where('status', 'pending')->count(),
                'processingOrders' => Order::where('status', 'processing')->count(),
                'completedOrders' => Order::where('status', 'completed')->count(),
                'cancelledOrders' => Order::where('status', 'cancelled')->count(),
                'totalRevenue' => Order::where('status', 'completed')->sum('total_amount'),
            ];
            
            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching stats'
            ], 500);
        }
    }

    /**
     * Get recent orders for AJAX requests
     */
    public function getRecentOrders()
    {
        try {
            $recentOrders = Order::with('items')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($order) {
                    return [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'customer_name' => $order->customer_name,
                        'total_amount' => $order->total_amount,
                        'status' => $order->status,
                        'created_at' => $order->created_at->format('M d, Y'),
                        'status_color' => $this->getStatusColor($order->status)
                    ];
                });
            
            return response()->json([
                'success' => true,
                'orders' => $recentOrders
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching recent orders'
            ], 500);
        }
    }

    /**
     * Get pending reviews for AJAX requests
     */
    public function getPendingReviews()
    {
        try {
            $pendingReviews = Review::with('product')
                ->where('is_approved', false)
                ->whereNull('rejected_at')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($review) {
                    return [
                        'id' => $review->id,
                        'product_name' => $review->product ? $review->product->name : 'Deleted Product',
                        'product_image' => $review->product && $review->product->main_image 
                            ? asset($review->product->main_image) 
                            : null,
                        'user_name' => $review->user_name,
                        'email' => $review->email,
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at->format('M d, Y')
                    ];
                });
            
            return response()->json([
                'success' => true,
                'reviews' => $pendingReviews
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching pending reviews'
            ], 500);
        }
    }

    /**
     * Get notification count for AJAX polling
     */
    public function getNotificationCount()
    {
        try {
            $count = Order::where('status', 'pending')->count();
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'count' => 0
            ]);
        }
    }

    /**
     * Get recent notifications for AJAX polling
     */
    public function getRecentNotifications()
    {
        try {
            $notifications = Order::select('id', 'order_number', 'customer_name', 'total_amount', 'created_at')
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($order) {
                    return [
                        'id' => $order->id,
                        'title' => "New Order #{$order->order_number}",
                        'message' => "{$order->customer_name} placed an order",
                        'amount' => $order->total_amount,
                        'time' => $order->created_at->diffForHumans(),
                        'read' => false
                    ];
                });
            
            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'count' => $notifications->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'notifications' => [],
                'count' => 0
            ]);
        }
    }

    /**
     * Get status color for badges
     */
    private function getStatusColor($status)
    {
        return match($status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'confirmed' => 'indigo',
            'packed' => 'purple',
            'shipped' => 'cyan',
            'in_transit' => 'orange',
            'out_for_delivery' => 'amber',
            'delivered' => 'green',
            'cancelled' => 'red',
            'refunded' => 'gray',
            default => 'gray'
        };
    }

    /**
     * Get empty dashboard data for error cases
     */
    private function getEmptyDashboardData()
    {
        return [
            'totalProducts' => 0,
            'activeProducts' => 0,
            'totalCategories' => 0,
            'totalViews' => 0,
            'totalReviews' => 0,
            'pendingReviews' => 0,
            'totalOrders' => 0,
            'todayOrders' => 0,
            'pendingOrders' => 0,
            'processingOrders' => 0,
            'completedOrders' => 0,
            'cancelledOrders' => 0,
            'totalRevenue' => 0,
            'recentProducts' => collect([]),
            'recentOrders' => collect([]),
            'pendingReviewsList' => collect([]),
            'orderGrowth' => 0,
            'revenueGrowth' => 0
        ];
    }
}