@extends('admin.layouts.admin')

@section('title', 'Manage Orders')
@section('page-title', 'Orders')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-4">
            <p class="text-sm text-yellow-600">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-4">
            <p class="text-sm text-blue-600">Processing</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['processing'] }}</p>
        </div>
        <div class="bg-cyan-50 rounded-lg shadow p-4">
            <p class="text-sm text-cyan-600">Shipped</p>
            <p class="text-2xl font-bold text-cyan-600">{{ $stats['shipped'] }}</p>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-4">
            <p class="text-sm text-green-600">Delivered</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['delivered'] }}</p>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-4">
            <p class="text-sm text-red-600">Cancelled</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search order #, customer..."
                   class="px-4 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
            
            <select name="status" class="px-4 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
                <option value="all">All Status</option>
                @foreach(App\Models\Order::STATUSES as $value => $label)
                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            
            <input type="date" 
                   name="date_from" 
                   value="{{ request('date_from') }}"
                   class="px-4 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
            
            <input type="date" 
                   name="date_to" 
                   value="{{ request('date_to') }}"
                   class="px-4 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
            
            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
        </form>
    </div>

    <!-- Orders - Responsive Cards on Mobile, Table on Desktop -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Mobile View (Card Layout) -->
        <div class="block md:hidden divide-y">
            @foreach($orders as $order)
            <div class="p-4 hover:bg-gray-50">
                <!-- Header with Order # and Date -->
                <div class="flex justify-between items-start mb-2">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-purple-600 font-mono font-semibold">
                        #{{ $order->order_number }}
                    </a>
                    <span class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                
                <!-- Customer Info -->
                <div class="mb-2">
                    <p class="font-medium">{{ $order->customer_name }}</p>
                    <p class="text-xs text-gray-500">{{ $order->customer_phone }}</p>
                </div>
                
                <!-- Order Details Grid -->
                <div class="grid grid-cols-2 gap-2 mb-3 text-sm">
                    <div>
                        <span class="text-gray-500">Items:</span>
                        <span class="font-medium ml-1">{{ $order->items->count() }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Total:</span>
                        <span class="font-semibold text-purple-600 ml-1">₦{{ number_format($order->total, 0) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Status:</span>
                        <span class="ml-1">
                            <div class="status-badge {{ $order->status }} inline-flex items-center text-xs">
                                <i class="fas 
                                    @if($order->status == 'delivered') fa-check-circle
                                    @elseif($order->status == 'shipped') fa-shipping-fast
                                    @elseif($order->status == 'processing' || $order->status == 'confirmed' || $order->status == 'packed') fa-spinner
                                    @elseif($order->status == 'pending') fa-clock
                                    @elseif($order->status == 'cancelled') fa-times-circle
                                    @elseif($order->status == 'refunded') fa-undo-alt
                                    @elseif($order->status == 'out_for_delivery') fa-truck
                                    @elseif($order->status == 'in_transit') fa-map-marked-alt
                                    @else fa-circle
                                    @endif mr-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </div>
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500">Payment:</span>
                        <span class="ml-1">
                            <div class="payment-badge {{ $order->payment_status }} inline-flex items-center text-xs">
                                <i class="fas 
                                    @if($order->payment_status == 'paid') fa-check-circle
                                    @elseif($order->payment_status == 'pending') fa-clock
                                    @elseif($order->payment_status == 'failed') fa-exclamation-circle
                                    @elseif($order->payment_status == 'refunded') fa-undo-alt
                                    @endif mr-1"></i>
                                {{ ucfirst($order->payment_status) }}
                            </div>
                        </span>
                    </div>
                </div>
                
                <!-- Action Buttons - Always Visible -->
                <div class="flex items-center space-x-3 pt-2 border-t">
                    <a href="{{ route('admin.orders.show', $order) }}" 
                       class="flex-1 bg-purple-50 text-purple-600 px-3 py-2 rounded-lg text-sm font-medium text-center hover:bg-purple-100 transition">
                        <i class="fas fa-eye mr-1"></i> View Details
                    </a>
                    
                    <form action="{{ route('admin.orders.destroy', $order) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')"
                          class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-50 text-red-600 px-3 py-2 rounded-lg text-sm font-medium hover:bg-red-100 transition">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop View (Table Layout) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-purple-600 hover:text-purple-700 font-mono text-sm">
                                {{ $order->order_number }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium">{{ $order->customer_name }}</div>
                            <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $order->items->count() }}</td>
                        <td class="px-6 py-4 text-sm font-semibold">₦{{ number_format($order->total, 0) }}</td>
                        <td class="px-6 py-4">
                            <div class="status-badge {{ $order->status }}">
                                <i class="fas 
                                    @if($order->status == 'delivered') fa-check-circle
                                    @elseif($order->status == 'shipped') fa-shipping-fast
                                    @elseif($order->status == 'processing' || $order->status == 'confirmed' || $order->status == 'packed') fa-spinner fa-pulse
                                    @elseif($order->status == 'pending') fa-clock
                                    @elseif($order->status == 'cancelled') fa-times-circle
                                    @elseif($order->status == 'refunded') fa-undo-alt
                                    @elseif($order->status == 'out_for_delivery') fa-truck
                                    @elseif($order->status == 'in_transit') fa-map-marked-alt
                                    @else fa-circle
                                    @endif"></i>
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="payment-badge {{ $order->payment_status }}">
                                <i class="fas 
                                    @if($order->payment_status == 'paid') fa-check-circle
                                    @elseif($order->payment_status == 'pending') fa-clock
                                    @elseif($order->payment_status == 'failed') fa-exclamation-circle
                                    @elseif($order->payment_status == 'refunded') fa-undo-alt
                                    @endif"></i>
                                {{ ucfirst($order->payment_status) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <!-- View Button -->
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="text-purple-600 hover:text-purple-800 transition p-2 hover:bg-purple-50 rounded-lg" 
                                   title="View Order">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('admin.orders.destroy', $order) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg" 
                                            title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<style>
/* Status badge styles */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    white-space: nowrap;
}

.status-badge.delivered {
    background-color: #d1fae5;
    color: #065f46;
}

.status-badge.shipped {
    background-color: #cffafe;
    color: #0891b2;
}

.status-badge.out_for_delivery {
    background-color: #fed7aa;
    color: #9a3412;
}

.status-badge.in_transit {
    background-color: #fed7aa;
    color: #9a3412;
}

.status-badge.processing, 
.status-badge.confirmed, 
.status-badge.packed {
    background-color: #dbeafe;
    color: #1e40af;
}

.status-badge.pending {
    background-color: #fef3c7;
    color: #92400e;
}

.status-badge.cancelled {
    background-color: #fee2e2;
    color: #991b1b;
}

.status-badge.refunded {
    background-color: #f3f4f6;
    color: #1f2937;
}

.status-badge i {
    margin-right: 0.25rem;
    font-size: 0.625rem;
}

/* Payment badge styles */
.payment-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    white-space: nowrap;
}

.payment-badge.paid {
    background-color: #d1fae5;
    color: #065f46;
}

.payment-badge.pending {
    background-color: #fef3c7;
    color: #92400e;
}

.payment-badge.failed {
    background-color: #fee2e2;
    color: #991b1b;
}

.payment-badge.refunded {
    background-color: #f3f4f6;
    color: #1f2937;
}

.payment-badge i {
    margin-right: 0.25rem;
    font-size: 0.625rem;
}

/* For spinning icons */
.fa-pulse {
    animation: fa-spin 2s infinite linear;
}

@keyframes fa-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

@push('scripts')
<script>
// Optional: Add confirmation toast for delete
document.querySelectorAll('form[onsubmit]').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
@endsection