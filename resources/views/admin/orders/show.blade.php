@extends('admin.layouts.admin')

@section('title', 'Order Details')
@section('page-title', 'Order #' . $order->order_number)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold">Order Information</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Placed: {{ $order->created_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Order Number</p>
                        <p class="font-mono text-sm">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Amount</p>
                        <p class="text-lg font-bold text-purple-600">₦{{ number_format($order->total, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Current Status</p>
                        <div>{!! $order->status_badge !!}</div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Payment Status</p>
                        <div>{!! $order->payment_status_badge !!}</div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                <div class="space-y-3">
                    @foreach ($order->items as $item)
                        <div class="flex items-center gap-4 border-b pb-3">
                            <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}"
                                class="w-16 h-16 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="font-medium">{{ $item->product_name }}</h4>
                                <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }} ×
                                    ₦{{ number_format($item->price, 0) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-purple-600">₦{{ number_format($item->subtotal, 0) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

         <!-- Tracking Timeline -->
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4 flex items-center">
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
                            bg-purple-600 ring-4 ring-purple-200
                        @else
                            bg-gray-400
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
                                <span class="text-xs bg-purple-100 text-purple-600 px-2 py-0.5 rounded-full">Current</span>
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
                    
                    <!-- Special Highlight for Delivered/Cancelled/Refunded -->
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
</div>





        </div>

        <!-- Actions Sidebar -->
        <div class="space-y-6">
            <!-- Unified Tracking Update Section -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-map-marked-alt text-purple-600 mr-2"></i>
                    Add Tracking Update
                </h3>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <!-- Status Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select name="status"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-purple-500"
                                required>
                                <option value="">Select new status</option>
                                @foreach (App\Models\Order::STATUSES as $value => $label)
                                    <option value="{{ $value }}" {{ $order->status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" name="location" placeholder="e.g., Lagos, Abuja, Enugu"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                            <textarea name="description" rows="3" placeholder="Detailed update about the order status..."
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-purple-500" required></textarea>
                        </div>

                        <!-- Timestamp (Hidden - uses current time) -->
                        <input type="hidden" name="tracked_at" value="{{ now() }}">

                        <!-- WhatsApp Notification -->
                        <label
                            class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg cursor-pointer hover:bg-green-100 transition">
                            <input type="checkbox" name="notify_customer" value="1"
                                class="mr-3 text-green-600 focus:ring-green-500 rounded">
                            <div>
                                <span class="text-sm font-medium text-gray-700 flex items-center">
                                    <i class="fab fa-whatsapp text-green-600 mr-1"></i>
                                    Notify customer via WhatsApp
                                </span>
                                <p class="text-xs text-gray-500 mt-0.5">Send this update to {{ $order->customer_phone }}
                                </p>
                            </div>
                        </label>

                        <button type="submit"
                            class="w-full bg-purple-600 text-white px-4 py-3 rounded-lg hover:bg-purple-700 transition flex items-center justify-center font-medium">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Add Tracking Update
                        </button>
                    </div>
                </form>
            </div>

            <!-- WhatsApp Notification Result (shows after update if checkbox was checked) -->
            @if (session('whatsapp_link'))
                <div class="bg-white rounded-lg shadow p-6 border-2 border-green-500">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <h4 class="text-sm font-semibold text-gray-900">WhatsApp Notification Ready</h4>
                            <p class="text-xs text-gray-600 mt-1">Click the button below to send the status update to the
                                customer:</p>
                            <div class="mt-3 flex space-x-2">
                                <a href="{{ session('whatsapp_link') }}" target="_blank"
                                    class="flex-1 bg-green-500 text-white text-center px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600 transition flex items-center justify-center">
                                    <i class="fab fa-whatsapp mr-2"></i>
                                    Send via WhatsApp
                                </a>
                                <button onclick="copyToClipboard('{{ session('whatsapp_link') }}')"
                                    class="px-3 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                This will open WhatsApp with a pre-filled message for {{ $order->customer_name }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Payment Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-credit-card text-green-600 mr-2"></i>
                    Payment Information
                </h3>

                <form action="{{ route('admin.orders.update-payment', $order) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <!-- Payment Status Dropdown -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Payment Status <span class="text-red-500">*</span>
                            </label>
                            <select name="payment_status"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                                @foreach (App\Models\Order::PAYMENT_STATUSES as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ $order->payment_status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Payment Method Dropdown - Nigerian Market Focused -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Payment Method
                            </label>
                            <select name="payment_method"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                                <option value="" {{ !$order->payment_method ? 'selected' : '' }}>-- Select payment
                                    method --</option>
                                <option value="Bank Transfer"
                                    {{ $order->payment_method == 'Bank Transfer' ? 'selected' : '' }}>🏦 Bank Transfer
                                </option>
                                <option value="Card Payment"
                                    {{ $order->payment_method == 'Card Payment' ? 'selected' : '' }}>💳 Card Payment
                                </option>
                                <option value="Cash on Delivery"
                                    {{ $order->payment_method == 'Cash on Delivery' ? 'selected' : '' }}>💵 Cash on
                                    Delivery</option>
                                <option value="POS" {{ $order->payment_method == 'POS' ? 'selected' : '' }}>🔄 POS
                                </option>
                                <option value="USSD" {{ $order->payment_method == 'USSD' ? 'selected' : '' }}>📱 USSD
                                </option>
                                <option value="Crypto" {{ $order->payment_method == 'Crypto' ? 'selected' : '' }}>₿ Crypto
                                    (USDT/Bitcoin)</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Select the method used for payment</p>
                        </div>

                        <!-- Current Payment Info (Display only) -->
                        @if ($order->payment_method || $order->payment_status)
                            <div class="bg-gray-50 rounded-lg p-3 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Current:</span>
                                    <span class="font-medium">
                                        @if ($order->payment_method)
                                            {{ $order->payment_method }} -
                                        @endif
                                        {!! $order->payment_status_badge !!}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <button type="submit"
                            class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition flex items-center justify-center font-medium">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Update Payment Information
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tracking Information - Using Order Number as Tracking Number -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Tracking Information</h3>
                <div class="space-y-4">
                    <!-- Display Order Number as Tracking Number -->
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-hashtag text-purple-600"></i>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-xs text-purple-600 font-medium">TRACKING NUMBER</p>
                                <p class="text-sm font-mono font-bold text-purple-800 mt-1 break-all">
                                    {{ $order->order_number }}</p>
                                <p class="text-xs text-gray-500 mt-2 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Your order number is used as the tracking number
                                </p>
                            </div>
                            <button onclick="copyToClipboard('{{ $order->order_number }}')"
                                class="ml-2 p-2 text-purple-600 hover:text-purple-800 hover:bg-purple-100 rounded-lg transition"
                                title="Copy tracking number">
                                <i class="far fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('admin.orders.update-tracking', $order) }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <!-- Hidden field to pass order number as tracking_number -->
                            <input type="hidden" name="tracking_number" value="{{ $order->order_number }}">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Courier Service</label>
                                <input type="text" name="courier_service" value="{{ $order->courier_service }}"
                                    placeholder="e.g., DHL, FedEx, GIG Logistics"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Delivery Date</label>
                                <input type="date" name="estimated_delivery"
                                    value="{{ $order->estimated_delivery?->format('Y-m-d') }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                                <i class="fas fa-truck mr-2"></i>
                                Update Courier Details
                            </button>
                        </div>
                    </form>

                    <!-- Quick Actions -->
                    <div class="flex gap-2 pt-2">
                        <button onclick="copyTrackingLink()"
                            class="flex-1 text-sm bg-gray-100 text-gray-600 px-3 py-2 rounded-lg hover:bg-gray-200 transition flex items-center justify-center">
                            <i class="fas fa-link mr-1"></i>
                            Copy Tracking Link
                        </button>
                        <a href="{{ route('order.track', ['order' => $order->order_number]) }}" target="_blank"
                            class="flex-1 text-sm bg-purple-100 text-purple-600 px-3 py-2 rounded-lg hover:bg-purple-200 transition flex items-center justify-center">
                            <i class="fas fa-external-link-alt mr-1"></i>
                            Test Tracking
                        </a>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Customer Section -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fab fa-whatsapp text-green-600 mr-2 text-xl"></i>
                    WhatsApp Customer
                </h3>

                <div class="space-y-4">
                    <!-- Customer Info -->
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</p>
                            <p class="text-xs text-gray-500">{{ $order->customer_phone }}</p>
                        </div>
                    </div>

                    <!-- Direct Chat Link -->
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" target="_blank"
                        class="flex items-center justify-center w-full p-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition group">
                        <i class="fab fa-whatsapp mr-2 text-lg"></i>
                        <span class="text-sm font-medium">Chat on WhatsApp</span>
                    </a>

                    <!-- Pre-written Message Templates -->
                    <div class="mt-4">
                        <p class="text-xs font-medium text-gray-500 mb-2">Quick Templates:</p>
                        <div class="flex flex-wrap gap-2">
                            <button onclick="copyTemplate('shipped')"
                                class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded hover:bg-blue-100 transition">
                                📦 Shipped
                            </button>
                            <button onclick="copyTemplate('delivered')"
                                class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded hover:bg-green-100 transition">
                                🎉 Delivered
                            </button>
                            <button onclick="copyTemplate('delay')"
                                class="text-xs bg-yellow-50 text-yellow-600 px-2 py-1 rounded hover:bg-yellow-100 transition">
                                ⏳ Delay
                            </button>
                            <button onclick="copyTemplate('payment')"
                                class="text-xs bg-purple-50 text-purple-600 px-2 py-1 rounded hover:bg-purple-100 transition">
                                💰 Payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Admin Notes -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Admin Notes</h3>
                <form action="{{ route('admin.orders.add-notes', $order) }}" method="POST">
                    @csrf
                    <textarea name="admin_notes" rows="4" placeholder="Add private notes about this order..."
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-purple-500">{{ $order->admin_notes }}</textarea>

                    <button type="submit"
                        class="w-full mt-3 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                        Save Notes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Functions -->
    @push('scripts')
        <script>
            // Template message function
            function copyTemplate(type) {
                let message = '';
                const orderNumber = '{{ $order->order_number }}';
                const customerName = '{{ $order->customer_name }}';
                const trackingLink = '{{ route('order.track', ['order' => $order->order_number]) }}';

                switch (type) {
                    case 'shipped':
                        message =
                            `Hello ${customerName}, your order #${orderNumber} has been shipped! 🚚 You can track it here: ${trackingLink}`;
                        break;
                    case 'delivered':
                        message =
                            `Hello ${customerName}, great news! Your order #${orderNumber} has been delivered! 🎉 Thank you for shopping with us!`;
                        break;
                    case 'delay':
                        message =
                            `Hello ${customerName}, we're sorry to inform you that your order #${orderNumber} is experiencing a slight delay. We'll update you soon. 🙏`;
                        break;
                    case 'payment':
                        message =
                            `Hello ${customerName}, your payment for order #${orderNumber} has been confirmed. We'll start processing your order right away! ✅`;
                        break;
                }

                // Create WhatsApp URL
                const phone = '{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}';
                const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;

                // Open in new tab
                window.open(url, '_blank');
            }

            // Copy to clipboard function
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function() {
                    showNotification('Tracking number copied to clipboard!', 'success');
                }, function(err) {
                    console.error('Could not copy text: ', err);
                    showNotification('Failed to copy', 'error');
                });
            }

            // Copy tracking link function
            function copyTrackingLink() {
                const trackingLink = '{{ route('order.track', ['order' => $order->order_number]) }}';
                navigator.clipboard.writeText(trackingLink).then(function() {
                    showNotification('Tracking link copied to clipboard!', 'success');
                }, function(err) {
                    console.error('Could not copy text: ', err);
                    showNotification('Failed to copy link', 'error');
                });
            }

            // Show notification function
            function showNotification(message, type = 'success') {
                // Remove any existing notification
                const existingNotification = document.querySelector('.tracking-notification');
                if (existingNotification) {
                    existingNotification.remove();
                }

                // Create notification element
                const notification = document.createElement('div');
                notification.className = `tracking-notification fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white text-sm`;
                notification.innerHTML = message;

                // Add to document
                document.body.appendChild(notification);

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        </script>
    @endpush
@endsection
