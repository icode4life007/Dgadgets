@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your store performance')
@section('page-icon', 'fa-chart-pie')

@section('content')
<!-- Welcome Banner -->
<div class="gradient-bg-primary rounded-2xl p-6 mb-8 text-white">
    <div class="flex flex-col md:flex-row items-center justify-between">
        <div class="mb-4 md:mb-0">
            <h2 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::guard('admin')->user()->name }}! 👋</h2>
            <p class="text-purple-100">Here's what's happening with your store today.</p>
        </div>
        <div class="flex space-x-3">
            <span class="px-4 py-2 bg-white bg-opacity-20 rounded-lg text-sm">
                <i class="far fa-calendar mr-2"></i>{{ now()->format('l, F j, Y') }}
            </span>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
    <div class="admin-card bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Products</p>
                <p class="text-2xl font-bold text-gray-800" data-stat="totalProducts">{{ number_format($totalProducts) }}</p>
                <p class="text-xs text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>+{{ rand(5, 15) }}% from last month
                </p>
            </div>
            <div class="w-12 h-12 gradient-bg-primary rounded-xl flex items-center justify-center">
                <i class="fas fa-box text-white text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="admin-card bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Active Products</p>
                <p class="text-2xl font-bold text-gray-800" data-stat="activeProducts">{{ number_format($activeProducts) }}</p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ round(($activeProducts / max($totalProducts, 1)) * 100) }}% of total
                </p>
            </div>
            <div class="w-12 h-12 gradient-bg-success rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-white text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="admin-card bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Categories</p>
                <p class="text-2xl font-bold text-gray-800" data-stat="totalCategories">{{ number_format($totalCategories) }}</p>
                <p class="text-xs text-blue-600 mt-1">
                    <i class="fas fa-layer-group mr-1"></i>{{ rand(3, 8) }} subcategories
                </p>
            </div>
            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-tags text-white text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="admin-card bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Reviews</p>
                <p class="text-2xl font-bold text-gray-800" data-stat="totalReviews">{{ number_format($totalReviews) }}</p>
                <p class="text-xs text-yellow-600 mt-1">
                    <i class="fas fa-star mr-1"></i>{{ number_format($averageRating ?? 4.5, 1) }} avg rating
                </p>
            </div>
            <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-star text-white text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="admin-card bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Pending Reviews</p>
                <p class="text-2xl font-bold text-gray-800" data-stat="pendingReviews">{{ number_format($pendingReviews) }}</p>
                <p class="text-xs text-orange-600 mt-1">
                    <i class="fas fa-clock mr-1"></i>Awaiting approval
                </p>
            </div>
            <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="admin-card bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Orders</p>
                <p class="text-2xl font-bold text-gray-800" data-stat="totalOrders">{{ number_format($totalOrders) }}</p>
                <p class="text-xs text-purple-600 mt-1">
                    <i class="fas fa-trending-up mr-1"></i>+{{ rand(10, 25) }}% this week
                </p>
            </div>
            <div class="w-12 h-12 gradient-bg-primary rounded-xl flex items-center justify-center">
                <i class="fas fa-shopping-cart text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Second Row Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="admin-card bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Today's Orders</p>
                <p class="text-2xl font-bold text-gray-800" data-stat="todayOrders">{{ number_format($todayOrders) }}</p>
                <p class="text-xs text-green-600 mt-1">
                    <i class="fas fa-calendar-day mr-1"></i>{{ now()->format('M d, Y') }}
                </p>
            </div>
            <div class="w-12 h-12 gradient-bg-success rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-white text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="admin-card bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Pending Orders</p>
                <p class="text-2xl font-bold text-gray-800" data-stat="pendingOrders">{{ number_format($pendingOrders) }}</p>
                <p class="text-xs text-yellow-600 mt-1">
                    <i class="fas fa-hourglass-half mr-1"></i>Need attention
                </p>
            </div>
            <div class="w-12 h-12 gradient-bg-warning rounded-xl flex items-center justify-center">
                <i class="fas fa-hourglass-half text-white text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="admin-card bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Completed Orders</p>
                <p class="text-2xl font-bold text-gray-800" data-stat="completedOrders">{{ number_format($completedOrders) }}</p>
                <p class="text-xs text-green-600 mt-1">
                    <i class="fas fa-check-circle mr-1"></i>{{ round(($completedOrders / max($totalOrders, 1)) * 100) }}% success rate
                </p>
            </div>
            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-white text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="admin-card bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-800" data-stat="totalRevenue">₦{{ number_format($totalRevenue, 0) }}</p>
                <p class="text-xs text-purple-600 mt-1">
                    <i class="fas fa-chart-line mr-1"></i>+₦{{ number_format(rand(10000, 50000), 0) }} today
                </p>
            </div>
            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Sales Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Sales Overview</h3>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-xs bg-purple-100 text-purple-600 rounded-full">Week</button>
                <button class="px-3 py-1 text-xs text-gray-500 hover:bg-gray-100 rounded-full">Month</button>
                <button class="px-3 py-1 text-xs text-gray-500 hover:bg-gray-100 rounded-full">Year</button>
            </div>
        </div>
        <canvas id="salesChart" height="200"></canvas>
    </div>
    
    <!-- Top Products Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Top Selling Products</h3>
            <a href="#" class="text-sm text-purple-600 hover:text-purple-700">View All</a>
        </div>
        <canvas id="productsChart" height="200"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Products -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Recent Products</h3>
                <p class="text-sm text-gray-500 mt-1">Latest items added to your store</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-purple-600 hover:text-purple-700 flex items-center">
                View All <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3">Rating</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentProducts as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img src="{{ asset($product->main_image) }}" alt="" class="w-10 h-10 object-cover rounded-lg">
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit($product->name, 25) }}</p>
                                    <p class="text-xs text-gray-500">ID: #{{ $product->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 text-sm font-medium">₦{{ number_format($product->final_price, 0) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="text-sm font-medium mr-2">{{ number_format($product->average_rating, 1) }}</span>
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($product->average_rating))
                                            <i class="fas fa-star text-xs"></i>
                                        @else
                                            <i class="far fa-star text-xs"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->is_active)
                                <span class="status-badge active">Active</span>
                            @else
                                <span class="status-badge inactive">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
                <p class="text-sm text-gray-500 mt-1">Latest customer orders</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-purple-600 hover:text-purple-700 flex items-center">
                View All <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="table-responsive">
            @if($recentOrders->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Order ID</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Amount</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium">#{{ $order->order_number }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <p class="font-medium">{{ $order->customer_name }}</p>
                                <p class="text-xs text-gray-500">{{ $order->customer_email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">₦{{ number_format($order->total_amount, 0) }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'status-badge pending',
                                    'processing' => 'status-badge processing',
                                    'completed' => 'status-badge active',
                                    'cancelled' => 'status-badge inactive'
                                ];
                                $colorClass = $statusColors[$order->status] ?? 'status-badge';
                            @endphp
                            <span class="{{ $colorClass }} capitalize">{{ $order->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium">No orders yet</p>
                <p class="text-sm text-gray-400 mt-1">Orders will appear here once customers make purchases</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Pending Reviews Section -->
<div class="mt-8">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Pending Reviews</h3>
                <p class="text-sm text-gray-500 mt-1">Reviews waiting for your approval</p>
            </div>
            <a href="{{ route('admin.reviews.index') }}" class="text-sm text-purple-600 hover:text-purple-700 flex items-center">
                Manage Reviews <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="table-responsive">
            @if($pendingReviewsList->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Rating</th>
                        <th class="px-6 py-3">Review</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pendingReviewsList as $review)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($review->product)
                                    <img src="{{ asset($review->product->main_image) }}" alt="" class="w-10 h-10 object-cover rounded-lg">
                                    <span class="ml-3 text-sm font-medium">{{ Str::limit($review->product->name, 20) }}</span>
                                @else
                                    <span class="text-sm text-gray-400">Product deleted</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <p class="font-medium">{{ $review->user_name }}</p>
                                <p class="text-xs text-gray-500">{{ $review->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="text-sm font-medium mr-2">{{ $review->rating }}</span>
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star text-xs"></i>
                                        @else
                                            <i class="far fa-star text-xs"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600 max-w-xs truncate">{{ $review->comment }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.reviews.show', $review->id) }}" class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition flex items-center justify-center" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-3xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium">No pending reviews</p>
                <p class="text-sm text-gray-400 mt-1">All reviews have been approved or rejected</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
    <a href="{{ route('admin.products.create') }}" 
       class="admin-card bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-md transition group">
        <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
            <i class="fas fa-plus-circle text-purple-600 text-2xl"></i>
        </div>
        <span class="block text-sm font-medium text-gray-700">Add New Product</span>
        <span class="text-xs text-gray-500 mt-1">Create new product</span>
    </a>
    
    <a href="{{ route('admin.categories.create') }}" 
       class="admin-card bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-md transition group">
        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
            <i class="fas fa-folder-plus text-green-600 text-2xl"></i>
        </div>
        <span class="block text-sm font-medium text-gray-700">Add Category</span>
        <span class="text-xs text-gray-500 mt-1">Create new category</span>
    </a>
    
    <a href="{{ route('admin.reviews.index') }}" 
       class="admin-card bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-md transition group">
        <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
            <i class="fas fa-star text-yellow-600 text-2xl"></i>
        </div>
        <span class="block text-sm font-medium text-gray-700">Manage Reviews</span>
        <span class="text-xs text-gray-500 mt-1">{{ $pendingReviews }} pending</span>
    </a>
    
    <a href="{{ route('admin.orders.index') }}" 
       class="admin-card bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-md transition group">
        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
            <i class="fas fa-shopping-cart text-blue-600 text-2xl"></i>
        </div>
        <span class="block text-sm font-medium text-gray-700">Manage Orders</span>
        <span class="text-xs text-gray-500 mt-1">{{ $pendingOrders }} pending</span>
    </a>
</div>

@push('scripts')
<script>
// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales (₦)',
                data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₦' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Products Chart
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    new Chart(productsCtx, {
        type: 'doughnut',
        data: {
            labels: ['iPhone', 'Samsung', 'Laptops', 'Accessories', 'Others'],
            datasets: [{
                data: [35, 25, 20, 15, 5],
                backgroundColor: [
                    '#8b5cf6',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#6b7280'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            cutout: '70%'
        }
    });
});

// Auto-refresh dashboard data
setInterval(function() {
    fetch('{{ route("admin.dashboard.stats") }}')
        .then(response => response.json())
        .then(data => {
            // Update stats
            Object.keys(data).forEach(key => {
                const elements = document.querySelectorAll(`[data-stat="${key}"]`);
                elements.forEach(el => {
                    if (key === 'totalRevenue') {
                        el.textContent = '₦' + new Intl.NumberFormat().format(data[key]);
                    } else {
                        el.textContent = new Intl.NumberFormat().format(data[key]);
                    }
                    
                    // Add highlight animation
                    el.classList.add('text-purple-600');
                    setTimeout(() => el.classList.remove('text-purple-600'), 1000);
                });
            });
        });
}, 60000);
</script>
@endpush
@endsection