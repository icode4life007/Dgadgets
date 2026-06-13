@extends('layouts.app')

@section('title', 'Shopping Cart - Dominion Gadget & Accessories')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-4 sm:mb-8">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-900">Shopping Cart</span>
        </nav>

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 sm:mb-8">Shopping Cart</h1>

        @if (empty($cartItems) || count($cartItems) === 0)
            <!-- Empty Cart -->
            <div class="bg-white rounded-lg shadow p-6 sm:p-12 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-shopping-cart text-4xl sm:text-6xl"></i>
                </div>
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-700 mb-4">Your cart is empty</h2>
                <p class="text-gray-500 mb-6 sm:mb-8 text-sm sm:text-base">Looks like you haven't added any items to your
                    cart yet.</p>
                <a href="{{ route('shop') }}"
                    class="inline-block bg-purple-600 text-white px-6 sm:px-8 py-2 sm:py-3 rounded-lg text-sm sm:text-base font-semibold hover:bg-purple-700 transition">
                    Continue Shopping
                </a>
            </div>
        @else
            <!-- Cart Items -->
            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                <!-- Cart Items List -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <!-- Mobile View - Card Layout -->
                        <div class="block lg:hidden divide-y">
                            @foreach ($cartItems as $item)
                                <div class="p-4 cart-item" id="cart-item-{{ $item['product']->id }}">
                                    <!-- Product Info -->
                                    <div class="flex gap-3 mb-3">
                                        <img src="{{ asset($item['product']->main_image) }}"
                                            alt="{{ $item['product']->name }}" class="w-20 h-20 object-cover rounded">
                                        <div class="flex-1">
                                            <a href="{{ route('product', $item['product']->slug) }}"
                                                class="text-sm font-medium text-gray-900 hover:text-purple-600 line-clamp-2">
                                                {{ $item['product']->name }}
                                            </a>
                                            @if ($item['product']->brand)
                                                <p class="text-xs text-gray-500 mt-1">{{ $item['product']->brand }}</p>
                                            @endif

                                            <!-- Price and Quantity for Mobile -->
                                            <div class="flex items-center justify-between mt-2">
                                                <span class="text-sm text-gray-900 font-medium">
                                                    ₦{{ number_format($item['product']->price, 0) }}
                                                </span>

                                                <button onclick="removeItem({{ $item['product']->id }})"
                                                    class="text-red-500 hover:text-red-700 transition p-1"
                                                    title="Remove item">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <button type="button"
                                                class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 rounded-l-lg transition"
                                                onclick="updateQuantity({{ $item['product']->id }}, 'decrease')">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <input type="number" id="quantity-{{ $item['product']->id }}"
                                                value="{{ $item['quantity'] }}" min="1"
                                                max="{{ $item['product']->quantity }}"
                                                class="w-12 text-center border-x border-gray-300 py-1.5 text-sm focus:outline-none"
                                                readonly>
                                            <button type="button"
                                                class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 rounded-r-lg transition"
                                                onclick="updateQuantity({{ $item['product']->id }}, 'increase')">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>

                                        <div class="text-right">
                                            <span class="text-xs text-gray-500">Total:</span>
                                            <span class="text-sm font-semibold text-purple-600 ml-1">
                                                ₦{{ number_format($item['subtotal'], 0) }}
                                            </span>
                                        </div>
                                    </div>

                                    @if ($item['product']->quantity < 10)
                                        <p class="text-xs text-red-500 mt-2">Only {{ $item['product']->quantity }} left in
                                            stock</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Desktop View - Table Layout -->
                        <table class="w-full hidden lg:table">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Product</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Price</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Quantity</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Total</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($cartItems as $item)
                                    <tr class="hover:bg-gray-50 transition cart-item" id="cart-item-{{ $item['product']->id }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <img src="{{ asset($item['product']->main_image) }}"
                                                    alt="{{ $item['product']->name }}"
                                                    class="w-16 h-16 object-cover rounded">
                                                <div class="ml-4">
                                                    <a href="{{ route('product', $item['product']->slug) }}"
                                                        class="text-sm font-medium text-gray-900 hover:text-purple-600">
                                                        {{ $item['product']->name }}
                                                    </a>
                                                    @if ($item['product']->brand)
                                                        <p class="text-xs text-gray-500 mt-1">{{ $item['product']->brand }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            ₦{{ number_format($item['product']->price, 0) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center border border-gray-300 rounded-lg w-32">
                                                <button type="button"
                                                    class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-lg transition"
                                                    onclick="updateQuantity({{ $item['product']->id }}, 'decrease')">
                                                    <i class="fas fa-minus text-xs"></i>
                                                </button>
                                                <input type="number" id="quantity-{{ $item['product']->id }}"
                                                    value="{{ $item['quantity'] }}" min="1"
                                                    max="{{ $item['product']->quantity }}"
                                                    class="w-12 text-center border-x border-gray-300 py-1 text-sm focus:outline-none"
                                                    readonly>
                                                <button type="button"
                                                    class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-lg transition"
                                                    onclick="updateQuantity({{ $item['product']->id }}, 'increase')">
                                                    <i class="fas fa-plus text-xs"></i>
                                                </button>
                                            </div>
                                            @if ($item['product']->quantity < 10)
                                                <p class="text-xs text-red-500 mt-1">Only {{ $item['product']->quantity }}
                                                    left</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-purple-600">
                                            ₦{{ number_format($item['subtotal'], 0) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <button onclick="removeItem({{ $item['product']->id }})"
                                                class="text-red-500 hover:text-red-700 transition" title="Remove item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Continue Shopping Button -->
                    <div class="mt-4 sm:mt-6">
                        <a href="{{ route('shop') }}"
                            class="text-purple-600 hover:text-purple-700 flex items-center text-sm sm:text-base">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-lg shadow p-4 sm:p-6 sticky top-4">
                        <h2 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Cart Summary</h2>

                        <div class="space-y-2 sm:space-y-3 mb-3 sm:mb-4">
                            <div class="flex justify-between text-xs sm:text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">₦{{ number_format($total, 0) }}</span>
                            </div>
                            <div class="flex justify-between text-xs sm:text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium">Calculated at checkout</span>
                            </div>
                            <div class="border-t pt-2 sm:pt-3 mt-2 sm:mt-3">
                                <div class="flex justify-between font-semibold">
                                    <span class="text-sm sm:text-base">Total</span>
                                    <span
                                        class="text-base sm:text-xl text-purple-600">₦{{ number_format($total, 0) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Inclusive of all taxes</p>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('checkout') }}"
                            class="block w-full bg-purple-600 text-white text-center px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-sm sm:text-base font-semibold hover:bg-purple-700 transition mb-2 sm:mb-3">
                            Proceed to Checkout
                        </a>

                        <!-- Clear Cart Button -->
                        <button onclick="clearCart()"
                            class="block w-full border border-gray-300 text-gray-600 px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-sm sm:text-base font-semibold hover:bg-gray-50 transition">
                            Clear Cart
                        </button>

                        <!-- Payment Methods -->
                        <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t">
                            <p class="text-xs text-gray-500 text-center mb-3">We accept:</p>
                            <div class="flex justify-center space-x-3 sm:space-x-4">
                                <i class="fab fa-cc-visa text-xl sm:text-2xl text-gray-400"></i>
                                <i class="fab fa-cc-mastercard text-xl sm:text-2xl text-gray-400"></i>
                                <i class="fab fa-cc-paypal text-xl sm:text-2xl text-gray-400"></i>
                                <i class="fas fa-mobile-alt text-xl sm:text-2xl text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            /* Prevent number input spinner */
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
                appearance: textfield;
            }

            /* Smooth transitions for cart items - FIXED: Using class instead of dynamic ID */
            .cart-item {
                transition: all 0.3s ease;
            }

            /* Line clamp for product names */
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Animation for cart updates */
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

    @push('scripts')
        <script>
            function updateQuantity(productId, action) {
                const input = document.getElementById(`quantity-${productId}`);
                let currentValue = parseInt(input.value);
                const maxValue = parseInt(input.max);

                let newValue = action === 'increase' ? currentValue + 1 : currentValue - 1;

                if (newValue >= 1 && newValue <= maxValue) {
                    // Update cart via AJAX
                    fetch('{{ route('cart.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: newValue
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update quantity display
                                input.value = newValue;

                                // Update cart count in header
                                updateCartCount(data.cartCount);

                                // Reload page to update totals
                                location.reload();
                            } else {
                                alert(data.message || 'Error updating cart');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error updating cart');
                        });
                }
            }

            function removeItem(productId) {
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    const row = document.getElementById(`cart-item-${productId}`);

                    fetch('{{ route('cart.remove') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Animate removal
                                row.style.transition = 'all 0.3s ease';
                                row.style.opacity = '0';
                                row.style.transform = 'translateX(20px)';

                                setTimeout(() => {
                                    row.remove();

                                    // Update cart count
                                    updateCartCount(data.cartCount);

                                    // Reload page if cart is empty
                                    if (data.cartCount === 0) {
                                        location.reload();
                                    } else {
                                        // Update totals
                                        location.reload();
                                    }
                                }, 300);
                            } else {
                                alert(data.message || 'Error removing item');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error removing item');
                        });
                }
            }

            function clearCart() {
                if (confirm('Are you sure you want to clear your entire cart?')) {
                    fetch('{{ route('cart.clear') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error clearing cart');
                        });
                }
            }

            function updateCartCount(count) {
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(el => {
                    el.textContent = count;
                });
            }
        </script>
    @endpush
@endsection