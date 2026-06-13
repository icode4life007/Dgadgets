@extends('layouts.app')

@section('title', 'Track Order - Dominion Gadget & Accessories')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 sm:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8 sm:mb-12">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3">Track Your Order</h1>
            <p class="text-gray-600 text-sm sm:text-base">Enter your order number to track its status and location</p>
        </div>

        <!-- Search Form - Using POST method -->
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-8">
            <form action="{{ route('order.track.post') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="text" 
                       name="order_number" 
                       value="{{ request('order') ?? request('order_number') }}"
                       placeholder="Enter order number (e.g., DOM-ABC123-20240315)"
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                       required>
                <button type="submit" 
                        class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Track Order
                </button>
            </form>
        </div>

        @if(isset($order) && $order)
            <!-- Order Details -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Order Header -->
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-white">
                        <div>
                            <h2 class="text-xl font-semibold">Order #{{ $order->order_number }}</h2>
                            <p class="text-purple-100 text-sm mt-1">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="mt-2 sm:mt-0 flex gap-2">
                            {!! $order->status_badge !!}
                            <!-- Payment Status Badge -->
                            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                @if($order->payment_status == 'paid') bg-green-500 text-white
                                @elseif($order->payment_status == 'pending') bg-yellow-500 text-white
                                @elseif($order->payment_status == 'failed') bg-red-500 text-white
                                @else bg-gray-500 text-white
                                @endif">
                                <i class="fas fa-credit-card mr-1"></i>
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="px-6 py-4 border-b">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Order Progress</span>
                        <span class="font-semibold text-purple-600">{{ $order->progress_percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-purple-600 h-2.5 rounded-full transition-all duration-500" 
                             style="width: {{ $order->progress_percentage }}%"></div>
                    </div>
                </div>

    <!-- Tracking Timeline -->
<div class="px-6 py-4">
    <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
        <i class="fas fa-map-marked-alt text-purple-600 mr-2"></i>
        Tracking Timeline
        @if($order->status === 'delivered')
            <span class="ml-auto text-sm bg-green-100 text-green-600 px-3 py-1 rounded-full flex items-center">
                <i class="fas fa-check-circle mr-1"></i>
                Delivered
            </span>
        @elseif($order->status === 'cancelled')
            <span class="ml-auto text-sm bg-red-100 text-red-600 px-3 py-1 rounded-full flex items-center">
                <i class="fas fa-times-circle mr-1"></i>
                Cancelled
            </span>
        @elseif($order->status === 'refunded')
            <span class="ml-auto text-sm bg-gray-100 text-gray-600 px-3 py-1 rounded-full flex items-center">
                <i class="fas fa-undo-alt mr-1"></i>
                Refunded
            </span>
        @else
            <span class="ml-auto text-xs text-gray-500">Most recent first</span>
        @endif
    </h3>
    
    <div class="space-y-4">
        @forelse($order->trackings->sortByDesc('tracked_at') as $index => $tracking)
            <div class="flex gap-3 {{ $index === 0 ? 'opacity-100' : 'opacity-90' }}">
                <div class="flex-shrink-0 relative">
                    <!-- Status dot with different colors based on status -->
                    <div class="w-3 h-3 mt-1.5 rounded-full 
                        @if($tracking->status === 'delivered') 
                            bg-green-500 ring-4 ring-green-200 
                        @elseif($tracking->status === 'out_for_delivery')
                            bg-amber-500 ring-4 ring-amber-200
                        @elseif($tracking->status === 'in_transit')
                            bg-orange-500 ring-4 ring-orange-200
                        @elseif($tracking->status === 'shipped')
                            bg-cyan-500 ring-4 ring-cyan-200
                        @elseif($tracking->status === 'packed')
                            bg-purple-500 ring-4 ring-purple-200
                        @elseif($tracking->status === 'confirmed')
                            bg-indigo-500 ring-4 ring-indigo-200
                        @elseif($tracking->status === 'processing')
                            bg-blue-500 ring-4 ring-blue-200
                        @elseif($tracking->status === 'pending')
                            bg-yellow-500 ring-4 ring-yellow-200
                        @elseif($tracking->status === 'cancelled')
                            bg-red-500 ring-4 ring-red-200
                        @elseif($tracking->status === 'refunded')
                            bg-gray-500 ring-4 ring-gray-200
                        @elseif($index === 0)
                            bg-green-500 ring-4 ring-green-200
                        @else
                            bg-purple-600
                        @endif">
                    </div>
                    @if(!$loop->last)
                        <div class="absolute top-4 left-1.5 w-0.5 h-full bg-gray-300 -translate-x-1/2"></div>
                    @endif
                </div>
                <div class="flex-1 pb-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                        <div class="flex items-center flex-wrap gap-2">
                            <p class="font-medium text-gray-900">
                                @switch($tracking->status)
                                    @case('pending')
                                        <span class="text-yellow-600">⏳ Pending</span>
                                        @break
                                    @case('processing')
                                        <span class="text-blue-600">🔄 Processing</span>
                                        @break
                                    @case('confirmed')
                                        <span class="text-indigo-600">✅ Confirmed</span>
                                        @break
                                    @case('packed')
                                        <span class="text-purple-600">📦 Packed</span>
                                        @break
                                    @case('shipped')
                                        <span class="text-cyan-600">📬 Shipped</span>
                                        @break
                                    @case('in_transit')
                                        <span class="text-orange-600">🚚 In Transit</span>
                                        @break
                                    @case('out_for_delivery')
                                        <span class="text-amber-600">🚀 Out for Delivery</span>
                                        @break
                                    @case('delivered')
                                        <span class="text-green-600">🎉 Delivered</span>
                                        @break
                                    @case('cancelled')
                                        <span class="text-red-600">❌ Cancelled</span>
                                        @break
                                    @case('refunded')
                                        <span class="text-gray-600">💰 Refunded</span>
                                        @break
                                    @default
                                        {{ ucfirst($tracking->status) }}
                                @endswitch
                            </p>
                            
                            @if($tracking->status === 'delivered')
                                <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full flex items-center">
                                    <i class="fas fa-check-circle mr-1 text-xs"></i>
                                    Completed
                                </span>
                            @elseif($tracking->status === 'cancelled')
                                <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full flex items-center">
                                    <i class="fas fa-times-circle mr-1 text-xs"></i>
                                    Cancelled
                                </span>
                            @elseif($tracking->status === 'refunded')
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full flex items-center">
                                    <i class="fas fa-undo-alt mr-1 text-xs"></i>
                                    Refunded
                                </span>
                            @elseif($index === 0 && !in_array($tracking->status, ['delivered', 'cancelled', 'refunded']))
                                <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full">Current</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-1 sm:mt-0">{{ $tracking->tracked_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    @if($tracking->location)
                        <p class="text-sm text-gray-600 mt-2">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                            <span class="font-medium">Location:</span> {{ $tracking->location }}
                        </p>
                    @endif
                    
                    @if($tracking->description)
                        <p class="text-sm text-gray-500 mt-1">{{ $tracking->description }}</p>
                    @endif
                    
                    <!-- Special Highlight for Final Statuses -->
                    @if($tracking->status === 'delivered')
                        <div class="mt-3 bg-green-50 border border-green-200 rounded-lg p-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-2 flex-1">
                                    <p class="text-xs font-medium text-green-800">Delivery Confirmation</p>
                                    <p class="text-sm text-green-700 mt-1">{{ $tracking->description }}</p>
                                    @if($tracking->location)
                                        <p class="text-xs text-green-600 mt-1">
                                            <i class="fas fa-map-pin mr-1"></i>
                                            {{ $tracking->location }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @elseif($tracking->status === 'cancelled')
                        <div class="mt-3 bg-red-50 border border-red-200 rounded-lg p-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-red-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-times text-white text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-2 flex-1">
                                    <p class="text-xs font-medium text-red-800">Order Cancelled</p>
                                    <p class="text-sm text-red-700 mt-1">{{ $tracking->description }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($tracking->status === 'refunded')
                        <div class="mt-3 bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-gray-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-undo-alt text-white text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-2 flex-1">
                                    <p class="text-xs font-medium text-gray-800">Refund Processed</p>
                                    <p class="text-sm text-gray-700 mt-1">{{ $tracking->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <div class="text-gray-400 mb-2">
                    <i class="fas fa-history text-4xl"></i>
                </div>
                <p class="text-gray-500 text-sm">No tracking updates yet</p>
                <p class="text-xs text-gray-400 mt-1">Check back later for updates</p>
            </div>
        @endforelse
    </div>

    <!-- Delivery Summary for Delivered Orders -->
    @if($order->status === 'delivered' && $order->delivered_at)
    <div class="mt-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-check-circle text-white"></i>
            </div>
            <div>
                <h4 class="font-semibold text-green-800">Order Delivered Successfully</h4>
                <p class="text-sm text-green-600">Delivered on {{ $order->delivered_at->format('l, F j, Y \a\t g:i A') }}</p>
                @php
                    $deliveredTracking = $order->trackings->where('status', 'delivered')->first();
                @endphp
                @if($deliveredTracking && $deliveredTracking->location)
                    <p class="text-xs text-green-500 mt-1">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ $deliveredTracking->location }}
                    </p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Cancelled Summary -->
    @if($order->status === 'cancelled')
    <div class="mt-6 p-4 bg-gradient-to-r from-red-50 to-red-100 rounded-lg border border-red-200">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-times-circle text-white"></i>
            </div>
            <div>
                <h4 class="font-semibold text-red-800">Order Cancelled</h4>
                <p class="text-sm text-red-600">Cancelled on {{ $order->updated_at->format('l, F j, Y \a\t g:i A') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Refunded Summary -->
    @if($order->status === 'refunded')
    <div class="mt-6 p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-undo-alt text-white"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Refund Processed</h4>
                <p class="text-sm text-gray-600">Refunded on {{ $order->updated_at->format('l, F j, Y \a\t g:i A') }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

                <!-- Payment Status Section - New Stylish Card -->
                <div class="border-t px-6 py-4 bg-gradient-to-br from-green-50 to-emerald-50">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-credit-card text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Payment Information</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Payment Status Card -->
                        <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition border-l-4 
                            @if($order->payment_status == 'paid') border-green-500
                            @elseif($order->payment_status == 'pending') border-yellow-500
                            @elseif($order->payment_status == 'failed') border-red-500
                            @else border-gray-500
                            @endif">
                            <div class="flex items-start">
                                <div class="w-8 h-8 
                                    @if($order->payment_status == 'paid') bg-green-100
                                    @elseif($order->payment_status == 'pending') bg-yellow-100
                                    @elseif($order->payment_status == 'failed') bg-red-100
                                    @else bg-gray-100
                                    @endif rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-circle text-sm
                                        @if($order->payment_status == 'paid') text-green-600
                                        @elseif($order->payment_status == 'pending') text-yellow-600
                                        @elseif($order->payment_status == 'failed') text-red-600
                                        @else text-gray-600
                                        @endif"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Payment Status</p>
                                    <p class="text-base font-semibold 
                                        @if($order->payment_status == 'paid') text-green-600
                                        @elseif($order->payment_status == 'pending') text-yellow-600
                                        @elseif($order->payment_status == 'failed') text-red-600
                                        @else text-gray-600
                                        @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Method Card -->
                        <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition border-l-4 border-purple-500">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-money-bill text-purple-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Payment Method</p>
                                    <p class="text-base font-semibold text-gray-900">
                                        {{ $order->payment_method ?? 'Not specified' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Total Amount Card -->
                        <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition border-l-4 border-blue-500">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-calculator text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Amount</p>
                                    <p class="text-base font-semibold text-blue-600">₦{{ number_format($order->total, 0) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Confirmation Badge -->
                    @if($order->payment_status == 'paid')
                    <div class="mt-4 flex justify-end">
                        <div class="bg-green-100 rounded-full px-4 py-2 inline-flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            <span class="text-sm font-semibold text-green-700">Payment Confirmed</span>
                        </div>
                    </div>
                    @elseif($order->payment_status == 'pending')
                    <div class="mt-4 flex justify-end">
                        <div class="bg-yellow-100 rounded-full px-4 py-2 inline-flex items-center">
                            <i class="fas fa-clock text-yellow-600 mr-2"></i>
                            <span class="text-sm font-semibold text-yellow-700">Awaiting Payment</span>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Delivery Information -->
                <div class="border-t px-6 py-4 bg-gray-50">
                    <h3 class="font-semibold text-gray-900 mb-3">Delivery Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Always show tracking number (order number) -->
                        <div class="col-span-2 sm:col-span-1">
                            <p class="text-xs text-gray-500">Tracking Number</p>
                            <div class="flex items-center">
                                <p class="text-sm font-mono font-semibold text-purple-600">{{ $order->order_number }}</p>
                                <button onclick="copyToClipboard('{{ $order->order_number }}')" 
                                        class="ml-2 text-gray-400 hover:text-purple-600 transition" 
                                        title="Copy tracking number">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        
                        @if($order->courier_service)
                        <div>
                            <p class="text-xs text-gray-500">Courier Service</p>
                            <p class="text-sm font-medium">{{ $order->courier_service }}</p>
                        </div>
                        @endif
                        
                        @if($order->estimated_delivery)
                        <div>
                            <p class="text-xs text-gray-500">Estimated Delivery</p>
                            <p class="text-sm font-medium">{{ $order->estimated_delivery->format('M d, Y') }}</p>
                        </div>
                        @endif
                        
                        @if($order->delivered_at)
                        <div>
                            <p class="text-xs text-gray-500">Delivered On</p>
                            <p class="text-sm font-medium">{{ $order->delivered_at->format('M d, Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="mt-3 flex gap-2">
                        <button onclick="copyTrackingLink()" 
                                class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded hover:bg-gray-200 transition flex items-center">
                            <i class="fas fa-link mr-1"></i>
                            Copy Tracking Link
                        </button>
                        <a href="https://wa.me/?text={{ urlencode('Track my order: ' . route('order.track', ['order' => $order->order_number])) }}" 
                           target="_blank"
                           class="text-xs bg-green-100 text-green-600 px-3 py-1 rounded hover:bg-green-200 transition flex items-center">
                            <i class="fab fa-whatsapp mr-1"></i>
                            Share on WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="border-t px-6 py-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Order Items</h3>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-3">
                            @if($item->product_image)
                                <img src="{{ asset($item->product_image) }}" 
                                     alt="{{ $item->product_name }}"
                                     class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-sm font-medium">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} × ₦{{ number_format($item->price, 0) }}</p>
                            </div>
                            <p class="text-sm font-semibold text-purple-600">₦{{ number_format($item->total, 0) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Customer Information - Enhanced Design -->
                <div class="border-t px-6 py-6 bg-gradient-to-br from-purple-50 to-indigo-50">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-truck text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Delivery Details</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Customer Name Card -->
                        <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition border-l-4 border-purple-600">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-purple-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Customer Name</p>
                                    <p class="text-base font-semibold text-gray-900">{{ $order->customer_name }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Phone Number Card -->
                        <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition border-l-4 border-green-500">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-phone-alt text-green-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Phone Number</p>
                                    <p class="text-base font-semibold text-gray-900">{{ $order->customer_phone }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address Card (Full Width) -->
                        <div class="md:col-span-2 bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition border-l-4 border-blue-500">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Delivery Address</p>
                                    <p class="text-base font-semibold text-gray-900">{{ $order->customer_address }}</p>
                                    <div class="mt-2 flex gap-2">
                                        <a href="https://maps.google.com/?q={{ urlencode($order->customer_address) }}" 
                                           target="_blank"
                                           class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200 transition inline-flex items-center">
                                            <i class="fas fa-map mr-1"></i> View on Map
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Delivery Status Badge -->
                    <div class="mt-4 flex justify-end">
                        <div class="bg-white rounded-full px-4 py-2 shadow-sm inline-flex items-center">
                            <span class="text-xs text-gray-500 mr-2">Delivery Status:</span>
                            <span class="text-sm font-semibold text-purple-600 flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                {{ $order->status == 'delivered' ? 'Delivered' : 'In Progress' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Need Help -->
                <div class="border-t px-6 py-4">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="https://wa.me/{{ config('contact.whatsapp', '2348165987691') }}" 
                           target="_blank"
                           class="inline-flex items-center text-green-600 hover:text-green-700">
                            <i class="fab fa-whatsapp mr-2 text-xl"></i>
                            Chat on WhatsApp
                        </a>
                        <span class="hidden sm:block text-gray-300">|</span>
                        <a href="tel:{{ config('contact.phone', '+234 703 226 1682') }}" 
                           class="inline-flex items-center text-purple-600 hover:text-purple-700">
                            <i class="fas fa-phone-alt mr-2 text-xl"></i>
                            {{ config('contact.phone', '+234 703 226 1682') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- New Order Button -->
            <div class="text-center mt-6">
                <a href="{{ route('shop') }}" 
                   class="inline-flex items-center text-purple-600 hover:text-purple-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Continue Shopping
                </a>
            </div>
        @elseif(request('order_number'))
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-search text-5xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Order Not Found</h3>
                <p class="text-gray-500 mb-6">We couldn't find an order with number "{{ request('order_number') }}"</p>
                <p class="text-sm text-gray-500">Please check the order number and try again.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showNotification('Tracking number copied to clipboard!', 'success');
    }, function(err) {
        console.error('Could not copy text: ', err);
        showNotification('Failed to copy', 'error');
    });
}

function copyTrackingLink() {
    const trackingLink = '{{ isset($order) ? route('order.track', ['order' => $order->order_number]) : '' }}';
    navigator.clipboard.writeText(trackingLink).then(function() {
        showNotification('Tracking link copied to clipboard!', 'success');
    }, function(err) {
        console.error('Could not copy text: ', err);
        showNotification('Failed to copy link', 'error');
    });
}

function copyAddress() {
    const address = '{{ $order->customer_address ?? '' }}';
    navigator.clipboard.writeText(address).then(function() {
        showNotification('Address copied to clipboard!', 'success');
    }, function(err) {
        console.error('Could not copy address: ', err);
        showNotification('Failed to copy address', 'error');
    });
}

function showNotification(message, type = 'success') {
    const existingNotification = document.querySelector('.tracking-notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `tracking-notification fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white text-sm animate-slide-in`;
    notification.innerHTML = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

<style>
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-in {
    animation: slideIn 0.3s ease-out;
}
</style>
@endpush
@endsection