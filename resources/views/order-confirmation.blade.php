@extends('layouts.app')

@section('title', 'Order Confirmed - Dominion Gadget & Accessories')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 sm:py-12 md:py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Success Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-8 sm:px-10 sm:py-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 bg-white rounded-full mb-4 sm:mb-6">
                    <i class="fas fa-check-circle text-4xl sm:text-5xl text-green-500"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2">
                    Order Received!
                </h1>
                <p class="text-green-100 text-sm sm:text-base md:text-lg">
                    Thank you for shopping with Dominion Gadget & Accessories. Your order has been successfully placed and is now being processed.
                </p>
            </div>

            <!-- Order Details -->
            <div class="px-6 py-6 sm:px-10 sm:py-8">
                <!-- Important: Save Your Order Number -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 sm:mb-8 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 font-medium">
                                ⭐ IMPORTANT: Save your order number to track your order!
                            </p>
                            <p class="text-xs text-yellow-600 mt-1">
                                Copy the order number below and use it on our tracking page to monitor your delivery status.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Order Number with Copy Button and Instructions -->
                <div class="text-center mb-4">
                    <div class="inline-flex flex-col items-center">
                        <span class="text-xs text-gray-500 mb-2">YOUR ORDER NUMBER</span>
                        <div class="flex items-center bg-green-100 text-green-700 px-6 py-3 rounded-full text-base sm:text-lg font-bold border-2 border-green-300 shadow-md">
                            <i class="fas fa-hashtag mr-2 text-green-600"></i>
                            <span id="orderNumberDisplay">
                                {{ $order->order_number ?? ($lastOrder['order']->order_number ?? 'DOM-' . strtoupper(uniqid())) }}
                            </span>
                            <button onclick="copyOrderNumber()" 
                                    class="ml-3 bg-green-600 text-white p-2 rounded-full hover:bg-green-700 focus:outline-none transition transform hover:scale-110 shadow-sm" 
                                    title="Copy order number">
                                <i class="far fa-copy text-sm"></i>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                            Click the copy button <i class="far fa-copy mx-1 text-green-600"></i> to save your order number
                        </p>
                    </div>
                </div>

                <!-- How to Track Your Order -->
                <div class="bg-blue-50 rounded-xl p-4 sm:p-5 mb-6">
                    <h3 class="text-sm font-semibold text-blue-800 mb-2 flex items-center">
                        <i class="fas fa-truck text-blue-600 mr-2"></i>
                        How to track your order:
                    </h3>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="flex items-center text-blue-700">
                            <span class="flex items-center justify-center w-6 h-6 bg-blue-200 text-blue-800 rounded-full text-xs font-bold mr-2">1</span>
                            <span class="text-xs sm:text-sm">Copy your order number</span>
                            <i class="fas fa-arrow-right mx-2 text-blue-400 hidden sm:inline"></i>
                        </div>
                        <div class="flex items-center text-blue-700">
                            <span class="flex items-center justify-center w-6 h-6 bg-blue-200 text-blue-800 rounded-full text-xs font-bold mr-2">2</span>
                            <span class="text-xs sm:text-sm">Click "Track Your Order"</span>
                            <i class="fas fa-arrow-right mx-2 text-blue-400 hidden sm:inline"></i>
                        </div>
                        <div class="flex items-center text-blue-700">
                            <span class="flex items-center justify-center w-6 h-6 bg-blue-200 text-blue-800 rounded-full text-xs font-bold mr-2">3</span>
                            <span class="text-xs sm:text-sm">Paste number to see updates</span>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Section with Items -->
                @if(isset($order) && $order->items && $order->items->count() > 0)
                <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6 mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-shopping-bag text-purple-600 mr-2"></i>
                        Your Order Summary
                    </h3>
                    
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                            <!-- Product Image -->
                            <div class="w-16 h-16 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                @if($item->product_image)
                                    <img src="{{ asset($item->product_image) }}" 
                                         alt="{{ $item->product_name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400 text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Details -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} × ₦{{ number_format($item->price, 0) }}</p>
                            </div>
                            
                            <!-- Subtotal -->
                            <div class="text-right">
                                <p class="text-sm font-semibold text-purple-600">₦{{ number_format($item->total, 0) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Order Totals -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">₦{{ number_format($order->subtotal, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-sm mt-2">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium">To be calculated</span>
                        </div>
                        <div class="flex justify-between text-base font-bold mt-3 pt-3 border-t border-gray-200">
                            <span>Total</span>
                            <span class="text-purple-600">₦{{ number_format($order->total, 0) }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tracking and Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-6 sm:mb-8">
                    <a href="{{ route('order.track', ['order' => $order->order_number ?? ($lastOrder['order']->order_number ?? '')]) }}" 
                       class="inline-flex items-center bg-purple-600 text-white px-8 py-4 rounded-xl text-base font-semibold hover:bg-purple-700 transition transform hover:scale-105 shadow-lg">
                        <i class="fas fa-truck mr-2"></i>
                        Track Your Order
                    </a>
                    
                    <a href="{{ route('shop') }}" 
                       class="inline-flex items-center bg-gray-200 text-gray-700 px-6 py-3 rounded-xl text-sm font-semibold hover:bg-gray-300 transition">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Continue Shopping
                    </a>
                </div>

                <!-- Quick Track Form (Alternative) -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-xs text-gray-600 mb-2 text-center">Or enter your order number manually:</p>
                    <form action="{{ route('order.track.post') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" 
                               name="order_number" 
                               value="{{ $order->order_number ?? ($lastOrder['order']->order_number ?? '') }}"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500"
                               placeholder="Enter order number"
                               readonly>
                        <button type="submit" 
                                class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">
                            Track
                        </button>
                    </form>
                </div>

                <!-- What Happens Next -->
                <div class="bg-gray-50 rounded-xl p-4 sm:p-6 mb-6 sm:mb-8">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">
                        <i class="fas fa-clock text-green-500 mr-2"></i>
                        What happens next?
                    </h3>
                    <ul class="space-y-2 sm:space-y-3">
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3 mt-0.5">1</span>
                            <span class="text-xs sm:text-sm text-gray-600">Save your order number <strong class="text-purple-600">{{ $order->order_number ?? ($lastOrder['order']->order_number ?? '') }}</strong> for tracking</span>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3 mt-0.5">2</span>
                            <span class="text-xs sm:text-sm text-gray-600">Our sales representative will message you on WhatsApp within 1 minute</span>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3 mt-0.5">3</span>
                            <span class="text-xs sm:text-sm text-gray-600">We'll confirm your order details and provide payment information</span>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3 mt-0.5">4</span>
                            <span class="text-xs sm:text-sm text-gray-600">Track your order status using your order number</span>
                        </li>
                    </ul>
                </div>

                <!-- Contact Information -->
                <div class="border-t border-b border-gray-200 py-4 sm:py-6 mb-6 sm:mb-8">
                    <div class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-6">
                        <div class="text-center">
                            <div class="text-xs sm:text-sm text-gray-500 mb-1">Need help?</div>
                            <a href="https://wa.me/{{ config('contact.whatsapp', '2348165987691') }}" target="_blank" 
                               class="inline-flex items-center text-green-600 hover:text-green-700 text-sm sm:text-base font-medium group">
                                <i class="fab fa-whatsapp mr-2 text-lg group-hover:scale-110 transition"></i>
                                Chat on WhatsApp
                            </a>
                        </div>
                        <div class="hidden sm:block w-px h-8 bg-gray-300"></div>
                        <div class="text-center">
                            <div class="text-xs sm:text-sm text-gray-500 mb-1">Call us</div>
                            <a href="tel:{{ config('contact.phone', '+234 703 226 1682') }}" 
                               class="inline-flex items-center text-purple-600 hover:text-purple-700 text-sm sm:text-base font-medium group">
                                <i class="fas fa-phone-alt mr-2 text-lg group-hover:scale-110 transition"></i>
                                {{ config('contact.phone', '+234 703 226 1682') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <a href="{{ route('shop') }}" 
                       class="flex-1 bg-purple-600 text-white text-center px-4 sm:px-6 py-3 sm:py-4 rounded-xl text-sm sm:text-base font-semibold hover:bg-purple-700 transition transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Place New Order
                    </a>
                    <a href="{{ route('home') }}" 
                       class="flex-1 border-2 border-purple-600 text-purple-600 text-center px-4 sm:px-6 py-3 sm:py-4 rounded-xl text-sm sm:text-base font-semibold hover:bg-purple-50 transition flex items-center justify-center">
                        <i class="fas fa-home mr-2"></i>
                        Back to Home
                    </a>
                </div>

                <!-- Reminder to Save Order Number -->
                <div class="mt-6 p-3 bg-purple-50 rounded-lg text-center">
                    <p class="text-xs text-purple-700 flex items-center justify-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        <strong>Pro tip:</strong> Take a screenshot or write down your order number 
                        <strong class="mx-1">{{ $order->order_number ?? ($lastOrder['order']->order_number ?? '') }}</strong> 
                        for future reference
                        <i class="fas fa-star text-yellow-500 ml-2"></i>
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-8 sm:mt-12">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">You might also like</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                @php
                    $recommendedProducts = \App\Models\Product::where('is_active', true)
                        ->inRandomOrder()
                        ->limit(4)
                        ->get();
                @endphp
                
                @foreach($recommendedProducts as $product)
                <a href="{{ route('product', $product->slug) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden group">
                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}" class="w-full h-20 sm:h-24 object-cover group-hover:scale-110 transition duration-300">
                    <div class="p-2 sm:p-3">
                        <h3 class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $product->name }}</h3>
                        <p class="text-xs text-purple-600 font-semibold mt-1">₦{{ number_format($product->price, 0) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Confetti Animation */
    @keyframes confetti {
        0% { transform: translateY(0) rotate(0); opacity: 1; }
        100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
    }
    
    .confetti {
        position: fixed;
        width: 10px;
        height: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        animation: confetti 3s ease-out forwards;
        pointer-events: none;
        z-index: 9999;
    }
    
    /* Copy button animation */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    
    .copy-success {
        animation: pulse 0.3s ease-in-out;
    }
    
    /* Toast notification */
    .toast-notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #1f2937;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        animation: slideIn 0.3s ease-out;
    }
    
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
    
    .toast-notification.fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }
    
    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translateY(20px);
        }
    }

    /* Blink animation for important message */
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    .blink {
        animation: blink 1.5s ease-in-out infinite;
    }
</style>
@endpush

@push('scripts')
<script>
// Copy order number function
function copyOrderNumber() {
    // Get the order number element
    const orderSpan = document.getElementById('orderNumberDisplay');
    let orderNumber = orderSpan.innerText.trim();
    
    // Create temporary input element
    const tempInput = document.createElement('input');
    tempInput.value = orderNumber;
    document.body.appendChild(tempInput);
    
    // Select and copy
    tempInput.select();
    tempInput.setSelectionRange(0, 99999); // For mobile
    document.execCommand('copy');
    
    // Remove temporary input
    document.body.removeChild(tempInput);
    
    // Visual feedback on button
    const button = event.currentTarget;
    const originalIcon = button.innerHTML;
    button.innerHTML = '<i class="fas fa-check text-white"></i>';
    button.classList.add('copy-success');
    
    // Show success message
    showToast('✅ Order number copied! Use it to track your order.');
    
    // Reset button after 2 seconds
    setTimeout(() => {
        button.innerHTML = '<i class="far fa-copy text-sm"></i>';
        button.classList.remove('copy-success');
    }, 2000);
}

// Toast notification function
function showToast(message) {
    // Check if toast already exists and remove it
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) {
        existingToast.remove();
    }
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-400 mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add to document
    document.body.appendChild(toast);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('fade-out');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 300);
    }, 3000);
}

// Confetti effect
document.addEventListener('DOMContentLoaded', function() {
    const colors = ['#f56565', '#48bb78', '#4299e1', '#ed8936', '#9f7aea', '#f687b3', '#667eea', '#764ba2'];
    
    for (let i = 0; i < 75; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
            confetti.style.animationDelay = (Math.random() * 2) + 's';
            confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.width = (Math.random() * 12 + 5) + 'px';
            confetti.style.height = (Math.random() * 12 + 5) + 'px';
            confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
            confetti.style.opacity = Math.random();
            document.body.appendChild(confetti);
            
            setTimeout(() => {
                if (confetti.parentNode) {
                    confetti.remove();
                }
            }, 5000);
        }, i * 50);
    }
});
</script>
@endpush