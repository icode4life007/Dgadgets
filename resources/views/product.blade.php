@extends('layouts.app')

@section('title', $product->name . ' - Dominion Gadget & Accessories')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-8">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('category', $product->category->slug) }}" class="text-gray-500 hover:text-purple-600">
                {{ $product->category->name }}
            </a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-900">{{ $product->name }}</span>
        </nav>

        <!-- Product Details - Main Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Images -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg p-6">
                    <!-- Main Image with Search Icon and Click to Zoom -->
                    <div class="relative mb-4 group">
                        <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}"
                            class="w-full h-[500px] object-cover rounded-lg cursor-zoom-in" id="mainImage"
                            onclick="openModal(0)">

                        <!-- Search Icon Overlay (opens modal) -->
                        <button onclick="openModal(0)"
                            class="absolute top-4 right-4 bg-white bg-opacity-75 p-3 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-purple-600 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Thumbnail Gallery -->
                    @php
                        $galleryImages = $product->safe_gallery_images ?? [];
                        $allImages = array_merge([$product->main_image], $galleryImages);
                    @endphp

                    @if (!empty($allImages) && count($allImages) > 1)
                        <div class="grid grid-cols-5 gap-4">
                            @foreach ($allImages as $index => $image)
                                <div class="relative">
                                    <img src="{{ asset($image) }}" alt="Thumbnail {{ $index + 1 }}"
                                        class="w-full h-20 object-cover rounded-lg cursor-pointer {{ $index === 0 ? 'border-2 border-purple-600' : 'hover:border-2 hover:border-purple-600' }} transition"
                                        onclick="document.getElementById('mainImage').src = this.src; openModal({{ $index }})">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Product Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg p-6 sticky top-4">
                    <!-- Title and SKU -->
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                    @if ($product->sku)
                        <p class="text-sm text-gray-500 mb-4">SKU: {{ $product->sku }}</p>
                    @endif

                    <!-- Price Section -->
                    <div class="mb-6">
                        @if ($product->old_price && $product->old_price > $product->price)
                            <span
                                class="text-gray-400 line-through text-lg">₦{{ number_format($product->old_price, 2) }}</span>
                        @endif
                        <div class="text-3xl font-bold text-purple-600">
                            ₦{{ number_format($product->price, 2) }}
                        </div>
                        @if ($product->tax > 0)
                            <p class="text-sm text-gray-500 mt-1">Inclusive of all taxes</p>
                        @endif
                    </div>

                    <!-- Stock Status - Dynamic with ID for real-time updates -->
                    <div class="mb-6" id="stock-status-container">
                        @if ($product->quantity > 0)
                            <span class="text-green-600 font-semibold stock-status in-stock">
                                <i class="fas fa-check-circle mr-2"></i><span
                                    id="stock-quantity">{{ $product->quantity }}</span> in stock
                            </span>
                            @if ($product->quantity <= 5)
                                <span class="text-xs text-orange-500 block mt-1">Only <span
                                        id="low-stock-count">{{ $product->quantity }}</span> left in stock - order
                                    soon!</span>
                            @endif
                        @else
                            <span class="text-red-600 font-semibold stock-status out-of-stock">
                                <i class="fas fa-times-circle mr-2"></i>Out of stock
                            </span>
                        @endif
                    </div>

                    <!-- Quantity and Add to Cart -->
                    <div id="add-to-cart-container">
                        @if ($product->quantity > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button"
                                            class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-l-lg transition"
                                            onclick="decrementQuantity()">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" id="quantity" value="1" min="1"
                                            max="{{ $product->quantity }}"
                                            class="w-20 text-center border-x border-gray-300 py-2 focus:outline-none"
                                            readonly>
                                        <button type="button"
                                            class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-r-lg transition"
                                            onclick="incrementQuantity()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                    <button onclick="addToCart()"
                                        class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition flex items-center justify-center">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Add to cart
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="mb-6">
                                <button disabled
                                    class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                    <i class="fas fa-times-circle mr-2"></i> Out of Stock
                                </button>
                                <p class="text-xs text-gray-500 text-center mt-2">This product is currently unavailable</p>
                            </div>
                        @endif
                    </div>

                    <!-- Categories and Tags -->
                    <div class="border-t pt-6 space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Category:</span>
                            <a href="{{ route('category', $product->category->slug) }}"
                                class="text-sm text-purple-600 hover:underline ml-2">
                                {{ $product->category->name }}
                            </a>
                        </div>

                        @if ($product->tags && count($product->tags) > 0)
                            <div>
                                <span class="text-sm font-medium text-gray-500">Tags:</span>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach ($product->tags as $tag)
                                        <a href="{{ route('shop', ['tag' => $tag]) }}"
                                            class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full hover:bg-purple-100 hover:text-purple-600 transition">
                                            {{ $tag }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Professional Dynamic Checkout Button -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        @php
                            $cart = Session::get('cart', []);
                            $cartCount = array_sum($cart);

                            // Calculate cart total
                            $cartTotal = 0;
                            foreach ($cart as $id => $quantity) {
                                $cartProduct = \App\Models\Product::find($id);
                                if ($cartProduct) {
                                    $cartTotal += $cartProduct->price * $quantity;
                                }
                            }
                        @endphp

                        @if ($cartCount > 0)
                            <!-- Checkout Button with Items - Professional Design -->
                            <!-- Checkout Button with Items - Professional Design -->
                            <a href="{{ route('checkout') }}"
                                class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">

                                <div class="px-4 py-4 sm:px-5 sm:py-5">
                                    <!-- Top row - Ready to Checkout centered -->
                                    <div class="flex justify-center mb-3">
                                        <div class="flex items-center bg-white bg-opacity-20 rounded-full px-3 py-1">
                                            <i class="fas fa-shopping-cart text-white text-xs mr-2"></i>
                                            <span class="text-xs font-medium text-white uppercase tracking-wider">Ready to
                                                Checkout</span>
                                        </div>
                                    </div>

                                    <!-- Middle row - Checkout and count centered -->
                                    <div class="flex flex-col items-center justify-center mb-3">
                                        <span class="text-lg sm:text-xl font-bold text-white flex items-center">
                                            Click Here TO Checkout {{ $cartCount }}
                                            {{ Str::plural('Item', $cartCount) }}
                                        </span>
                                        <div class="flex items-center mt-1">
                                            <i class="fas fa-arrow-down text-white text-xs opacity-75 mr-1"></i>
                                            <span class="text-xs text-purple-100">proceed</span>
                                            <i class="fas fa-arrow-down text-white text-xs opacity-75 ml-1"></i>
                                        </div>
                                    </div>

                                    <!-- Bottom row - Price centered -->
                                    <div class="flex justify-center">
                                        <div class="bg-white text-purple-700 rounded-xl px-6 py-3 shadow-lg text-center">
                                            <span class="text-xs font-medium text-purple-500 block mb-1">Total
                                                Amount</span>
                                            <span
                                                class="text-xl sm:text-2xl font-black text-purple-700">₦{{ number_format($cartTotal, 0) }}</span>
                                        </div>
                                    </div>
                                </div>




                            </a>

                            <!-- Quick actions below button -->
                            <div class="flex items-center justify-between mt-2 px-1">
                                <a href="{{ route('cart') }}"
                                    class="text-xs text-gray-500 hover:text-purple-600 transition flex items-center">
                                    <i class="fas fa-shopping-bag mr-1"></i>
                                    View Cart Details
                                </a>
                                <span class="text-xs text-gray-400 flex items-center">
                                    <i class="fas fa-lock mr-1"></i>
                                    Secure Checkout
                                </span>
                            </div>
                        @else
                            <!-- Empty Cart - Professional & Compact Design -->
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white rounded-xl border border-purple-100 shadow-sm overflow-hidden">
                                <div class="px-4 py-4 sm:px-5">
                                    <!-- Header with icon and status -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-purple-100 w-10 h-10 rounded-full flex items-center justify-center mr-3 shadow-sm">
                                                <i class="fas fa-shopping-cart text-purple-500 text-lg"></i>
                                            </div>
                                            <div>
                                                <span
                                                    class="text-xs font-medium text-gray-400 uppercase tracking-wider">Your
                                                    Cart</span>
                                                <div class="text-xl font-bold text-gray-900 leading-tight">is empty</div>
                                            </div>
                                        </div>
                                        <div class="bg-purple-50 px-3 py-1.5 rounded-full">
                                            <span class="text-xs font-semibold text-purple-600">Select Product</span>
                                        </div>
                                    </div>

                                    <!-- Instruction steps - clean horizontal layout -->
                                    <div class="flex items-center justify-between bg-purple-50/50 rounded-lg p-2 mb-3">
                                        <div class="flex items-center text-gray-700">
                                            <span
                                                class="w-5 h-5 bg-purple-200 text-purple-700 rounded-full flex items-center justify-center text-xs font-bold mr-1">1</span>
                                            <span class="text-xs">Choose qty</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                        <div class="flex items-center text-gray-700">
                                            <span
                                                class="w-5 h-5 bg-purple-200 text-purple-700 rounded-full flex items-center justify-center text-xs font-bold mr-1">2</span>
                                            <span class="text-xs">Add to cart</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                        <div class="flex items-center text-gray-700">
                                            <span
                                                class="w-5 h-5 bg-purple-200 text-purple-700 rounded-full flex items-center justify-center text-xs font-bold mr-1">3</span>
                                            <span class="text-xs">Checkout</span>
                                        </div>
                                    </div>

                                    <!-- Call to action -->
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <i class="fas fa-info-circle text-purple-400 mr-1"></i>
                                            Start by selecting quantity
                                        </p>
                                        <div class="flex space-x-1">
                                            <span
                                                class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-mobile-alt text-gray-500 text-xs"></i>
                                            </span>
                                            <span
                                                class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-laptop text-gray-500 text-xs"></i>
                                            </span>
                                            <span
                                                class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-headphones text-gray-500 text-xs"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Description and Reviews Tabs -->
        <div class="mt-12 bg-white rounded-lg">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="showTab('description')" id="tab-description-btn"
                        class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-purple-600 text-purple-600">
                        Description
                    </button>
                    <button onclick="showTab('reviews')" id="tab-reviews-btn"
                        class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Reviews ({{ isset($reviews) ? $reviews->total() : 0 }})
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Description Tab -->
                <div id="tab-description" class="tab-content">
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($product->description)) !!}
                    </div>

                    @if ($product->specifications && count($product->specifications) > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Specifications</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($product->specifications as $key => $value)
                                    <div class="border-b py-2">
                                        <span class="font-medium">{{ $key }}:</span>
                                        <span class="text-gray-600 ml-2">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Reviews Tab -->
                <div id="tab-reviews" class="tab-content hidden">
                    <div class="max-w-3xl">
                        <!-- Existing Reviews -->
                        @if (isset($reviews) && $reviews->count() > 0)
                            <div class="space-y-6 mb-8">
                                @foreach ($reviews as $review)
                                    <div class="border-b pb-6">
                                        <div class="flex items-center mb-2">
                                            <div class="flex text-yellow-400">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span
                                                class="ml-2 text-sm text-gray-500">{{ $review->created_at->format('F j, Y') }}</span>
                                        </div>
                                        <p class="text-gray-700">{{ $review->comment }}</p>
                                        <p class="text-sm text-gray-500 mt-2">- {{ $review->user_name ?? 'Anonymous' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                            {{ $reviews->links() }}
                        @else
                            <p class="text-gray-500 text-center py-8">There are no reviews yet.</p>
                        @endif

                        <!-- Review Form -->
                        <div id="review-form" class="mt-8 border-t pt-8">
                            <h3 class="text-lg font-semibold mb-4">Write a Review for "{{ $product->name }}"</h3>

                            <form action="{{ route('product.review', $product) }}" method="POST" class="space-y-6">
                                @csrf

                                <!-- Rating -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating *</label>
                                    <div class="flex space-x-2 text-2xl text-gray-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="far fa-star cursor-pointer hover:text-yellow-400 rating-star"
                                                data-rating="{{ $i }}"
                                                onclick="setRating({{ $i }})"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating" value="{{ old('rating', 5) }}"
                                        required>
                                    @error('rating')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Review Comment -->
                                <div>
                                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Your Review
                                        *</label>
                                    <textarea name="comment" id="comment" rows="4"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-purple-600 @error('comment') border-red-500 @enderror"
                                        placeholder="Share your experience with this product..." required>{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name
                                        *</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', session('reviewer_name', auth()->check() ? auth()->user()->name : '')) }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-purple-600 @error('name') border-red-500 @enderror"
                                        placeholder="Your full name" required>
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                        *</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', session('reviewer_email', auth()->check() ? auth()->user()->email : '')) }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-purple-600 @error('email') border-red-500 @enderror"
                                        placeholder="your@email.com" required>
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Save info checkbox -->
                                <div class="flex items-center">
                                    <input type="checkbox" name="save_info" id="save_info"
                                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                        {{ old('save_info', session()->has('reviewer_name')) ? 'checked' : '' }}>
                                    <label for="save_info" class="ml-2 text-sm text-gray-600">
                                        Save my name and email for next time
                                    </label>
                                </div>

                                <!-- Submit -->
                                <div>
                                    <button type="submit"
                                        class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition flex items-center">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <section class="mt-12">
                <h2 class="text-xl font-bold mb-6">Related Products</h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        @include('partials.product-card', ['product' => $related])
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <!-- Image Lightbox Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 transition-opacity"
        onclick="closeModal()">
        <div class="relative h-full flex items-center justify-center">
            <!-- Close button -->
            <button onclick="closeModal()"
                class="absolute top-4 right-4 text-white hover:text-gray-300 z-50 bg-black bg-opacity-50 rounded-full p-3 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <!-- Zoom controls -->
            <div class="absolute top-4 left-4 flex space-x-2 bg-black bg-opacity-50 rounded-lg p-2">
                <button onclick="zoomIn()" class="text-white hover:text-purple-400 p-2 transition" title="Zoom In">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                    </svg>
                </button>
                <button onclick="zoomOut()" class="text-white hover:text-purple-400 p-2 transition" title="Zoom Out">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path>
                    </svg>
                </button>
                <button onclick="resetZoom()" class="text-white hover:text-purple-400 p-2 transition" title="Reset Zoom">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Fullscreen button -->
            <button onclick="toggleFullscreen()"
                class="absolute top-4 left-32 text-white hover:text-purple-400 bg-black bg-opacity-50 rounded-lg p-2 transition"
                title="Toggle Fullscreen">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m4 0v4m0 0l-5-5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                    </path>
                </svg>
            </button>

            <!-- Navigation buttons -->
            <button onclick="prevImage()"
                class="absolute left-4 text-white hover:text-purple-400 bg-black bg-opacity-50 rounded-full p-3 transition"
                title="Previous">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button onclick="nextImage()"
                class="absolute right-4 text-white hover:text-purple-400 bg-black bg-opacity-50 rounded-full p-3 transition"
                title="Next">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Image container -->
            <div class="relative max-w-7xl max-h-screen p-4" onclick="event.stopPropagation()">
                <img id="modalImage" src="" alt="Product preview"
                    class="max-w-full max-h-[90vh] object-contain transition-transform duration-300">

                <!-- Image counter -->
                <div
                    class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white px-4 py-2 rounded-full text-sm">
                    <span id="currentImageIndex">1</span> / <span id="totalImages">1</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Product ID for stock checking
        const productId = {{ $product->id }};

        // Check stock periodically (every 30 seconds)
        let stockCheckInterval;

        function startStockChecking() {
            // Check immediately
            checkStock();
            // Then check every 30 seconds
            stockCheckInterval = setInterval(checkStock, 30000);
        }

        function checkStock() {
            fetch(`/api/products/${productId}/stock`)
                .then(response => response.json())
                .then(data => {
                    updateStockDisplay(data.quantity);
                })
                .catch(error => console.error('Error checking stock:', error));
        }

        function updateStockDisplay(quantity) {
            const stockContainer = document.getElementById('stock-status-container');
            const addToCartContainer = document.getElementById('add-to-cart-container');

            if (quantity > 0) {
                // Update stock display
                stockContainer.innerHTML = `
                    <span class="text-green-600 font-semibold stock-status in-stock">
                        <i class="fas fa-check-circle mr-2"></i><span id="stock-quantity">${quantity}</span> in stock
                    </span>
                    ${quantity <= 5 ? `<span class="text-xs text-orange-500 block mt-1">Only ${quantity} left in stock - order soon!</span>` : ''}
                `;

                // Update add to cart section if it was out of stock
                if (addToCartContainer.querySelector('button[disabled]')) {
                    addToCartContainer.innerHTML = `
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button type="button"
                                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-l-lg transition"
                                        onclick="decrementQuantity()">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1" max="${quantity}"
                                        class="w-20 text-center border-x border-gray-300 py-2 focus:outline-none" readonly>
                                    <button type="button"
                                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-r-lg transition"
                                        onclick="incrementQuantity()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <button onclick="addToCart()"
                                    class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition flex items-center justify-center">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Add to cart
                                </button>
                            </div>
                        </div>
                    `;
                } else {
                    // Just update the max attribute
                    const qtyInput = document.getElementById('quantity');
                    if (qtyInput) {
                        qtyInput.max = quantity;
                        if (parseInt(qtyInput.value) > quantity) {
                            qtyInput.value = quantity;
                        }
                    }
                }
            } else {
                // Out of stock
                stockContainer.innerHTML = `
                    <span class="text-red-600 font-semibold stock-status out-of-stock">
                        <i class="fas fa-times-circle mr-2"></i>Out of stock
                    </span>
                `;

                addToCartContainer.innerHTML = `
                    <div class="mb-6">
                        <button disabled 
                                class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                            <i class="fas fa-times-circle mr-2"></i> Out of Stock
                        </button>
                        <p class="text-xs text-gray-500 text-center mt-2">This product is currently unavailable</p>
                    </div>
                `;
            }
        }

        // Image Gallery Variables
        let currentZoom = 1;
        let currentImageIndex = 0;
        let galleryImages = [
            @foreach ($allImages as $image)
                '{{ asset($image) }}',
            @endforeach
        ];

        // Filter out any empty values
        galleryImages = galleryImages.filter(img => img && img.trim() !== '');

        // Modal Functions
        function openModal(index) {
            currentImageIndex = index;
            updateModalImage();
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            resetZoom();
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = '';
            resetZoom();
        }

        function updateModalImage() {
            const modalImg = document.getElementById('modalImage');
            modalImg.src = galleryImages[currentImageIndex];
            document.getElementById('currentImageIndex').textContent = currentImageIndex + 1;
            document.getElementById('totalImages').textContent = galleryImages.length;
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            updateModalImage();
            resetZoom();
        }

        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            updateModalImage();
            resetZoom();
        }

        // Zoom Functions
        function zoomIn() {
            currentZoom += 0.2;
            if (currentZoom > 3) currentZoom = 3;
            applyZoom();
        }

        function zoomOut() {
            currentZoom -= 0.2;
            if (currentZoom < 0.5) currentZoom = 0.5;
            applyZoom();
        }

        function resetZoom() {
            currentZoom = 1;
            applyZoom();
        }

        function applyZoom() {
            const modalImg = document.getElementById('modalImage');
            modalImg.style.transform = `scale(${currentZoom})`;
        }

        // Fullscreen Function
        function toggleFullscreen() {
            const modal = document.getElementById('imageModal');

            if (!document.fullscreenElement) {
                if (modal.requestFullscreen) {
                    modal.requestFullscreen();
                } else if (modal.webkitRequestFullscreen) {
                    modal.webkitRequestFullscreen();
                } else if (modal.msRequestFullscreen) {
                    modal.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('imageModal');
            if (modal.classList.contains('hidden')) return;

            switch (e.key) {
                case 'Escape':
                    closeModal();
                    break;
                case 'ArrowLeft':
                    prevImage();
                    break;
                case 'ArrowRight':
                    nextImage();
                    break;
                case '+':
                case '=':
                    zoomIn();
                    break;
                case '-':
                    zoomOut();
                    break;
                case '0':
                    resetZoom();
                    break;
                case 'f':
                case 'F':
                    toggleFullscreen();
                    break;
            }
        });

        // Touch support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        document.getElementById('modalImage').addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.getElementById('modalImage').addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            if (touchEndX < touchStartX - swipeThreshold) {
                nextImage();
            }
            if (touchEndX > touchStartX + swipeThreshold) {
                prevImage();
            }
        }

        // Pinch to zoom
        let initialDistance = 0;

        document.getElementById('modalImage').addEventListener('touchstart', function(e) {
            if (e.touches.length === 2) {
                const dx = e.touches[0].clientX - e.touches[1].clientX;
                const dy = e.touches[0].clientY - e.touches[1].clientY;
                initialDistance = Math.sqrt(dx * dx + dy * dy);
            }
        });

        document.getElementById('modalImage').addEventListener('touchmove', function(e) {
            e.preventDefault();
            if (e.touches.length === 2) {
                const dx = e.touches[0].clientX - e.touches[1].clientX;
                const dy = e.touches[0].clientY - e.touches[1].clientY;
                const currentDistance = Math.sqrt(dx * dx + dy * dy);

                if (initialDistance > 0) {
                    const scale = currentDistance / initialDistance;
                    currentZoom = Math.min(Math.max(scale, 0.5), 3);
                    applyZoom();
                }
            }
        });

        // Quantity functions
        function incrementQuantity() {
            let input = document.getElementById('quantity');
            let max = parseInt(input.getAttribute('max'));
            let value = parseInt(input.value) || 1;
            if (value < max) {
                input.value = value + 1;
            }
        }

        function decrementQuantity() {
            let input = document.getElementById('quantity');
            let value = parseInt(input.value) || 1;
            if (value > 1) {
                input.value = value - 1;
            }
        }

        // Add to cart function
        function addToCart() {
            let quantity = document.getElementById('quantity').value;

            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: {{ $product->id }},
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCount(data.cartCount);

                        const messageDiv = document.createElement('div');
                        messageDiv.className =
                            'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50 animate-slide-in';
                        messageDiv.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>"{{ $product->name }}" has been added to your cart.</span>
                            <a href="{{ route('cart') }}" class="ml-4 text-green-700 font-semibold hover:underline">View cart</a>
                        </div>
                    `;
                        document.body.appendChild(messageDiv);

                        setTimeout(() => {
                            messageDiv.remove();
                        }, 5000);

                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error adding to cart:', error);
                });
        }

        // Update cart count in header
        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(el => {
                el.textContent = count;
            });
        }

        // Tab switching
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-purple-600', 'text-purple-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            document.getElementById(`tab-${tabName}`).classList.remove('hidden');

            const activeButton = document.getElementById(`tab-${tabName}-btn`);
            activeButton.classList.add('active', 'border-purple-600', 'text-purple-600');
            activeButton.classList.remove('border-transparent', 'text-gray-500');
        }

        // Rating stars
        function setRating(rating) {
            document.getElementById('rating').value = rating;

            document.querySelectorAll('.rating-star').forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('far', 'text-gray-400');
                    star.classList.add('fas', 'text-yellow-400');
                } else {
                    star.classList.remove('fas', 'text-yellow-400');
                    star.classList.add('far', 'text-gray-400');
                }
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            setRating(5);
            document.getElementById('totalImages').textContent = galleryImages.length;

            // Start periodic stock checking
            startStockChecking();

            if (window.location.hash === '#review-form') {
                setTimeout(() => {
                    const reviewForm = document.getElementById('review-form');
                    if (reviewForm) {
                        reviewForm.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }, 100);
            }

            const messages = document.querySelectorAll('.bg-green-100, .bg-red-100');
            messages.forEach(message => {
                setTimeout(() => {
                    message.style.transition = 'opacity 0.5s';
                    message.style.opacity = '0';
                    setTimeout(() => {
                        message.remove();
                    }, 500);
                }, 5000);
            });
        });

        // Clean up interval when leaving page
        window.addEventListener('beforeunload', function() {
            if (stockCheckInterval) {
                clearInterval(stockCheckInterval);
            }
        });
    </script>
@endpush

@push('styles')
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

        @keyframes shine {
            100% {
                left: 200%;
            }
        }

        .animate-shine {
            animation: shine 1.5s ease-in-out infinite;
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        #imageModal {
            transition: opacity 0.3s ease;
        }

        #imageModal.hidden {
            opacity: 0;
            pointer-events: none;
        }

        #modalImage {
            transition: transform 0.2s ease;
            cursor: grab;
        }

        #modalImage:active {
            cursor: grabbing;
        }

        #imageModal:fullscreen {
            background: black;
        }

        #imageModal:fullscreen #modalImage {
            max-height: 100vh;
        }
    </style>
@endpush
