@extends('layouts.app')

@section('content')
    <!-- Hero Section - Redesigned to match reference image -->
    <div class="relative overflow-hidden bg-gradient-to-r from-purple-600 to-indigo-600">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-12 items-center">
                <!-- Left Content -->
                <div class="text-white text-center lg:text-left order-2 lg:order-1">
                    <!-- Badge -->
                    <div
                        class="inline-block bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-semibold mb-4 md:mb-6">
                        <i class="fas fa-check-circle mr-2"></i>
                        Certified Pre Owned & New Phones
                    </div>

                    <!-- Main Heading -->
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-3 md:mb-4 leading-tight">
                        <span class="text-yellow-300">Free Cover & Cable</span><br>
                        With Every Device!
                    </h1>

                    <!-- Secondary Text -->
                    <p class="text-base md:text-lg text-purple-100 max-w-xl mx-auto lg:mx-0">
                        New & Refurbished Smartphones at Unbeatable Prices
                    </p>

                    <!-- CTA Button -->
                    <div class="mt-4 md:mt-6 mb-6 md:mb-8">
                        <a href="{{ route('shop') }}"
                            class="inline-block px-8 md:px-10 py-3 md:py-4 bg-yellow-400 text-purple-900 rounded-lg font-bold text-base md:text-lg hover:bg-yellow-300 transition transform hover:scale-105 shadow-xl">
                            SHOP NOW <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Content - Hero Image (Visible on all devices) -->
                <div class="relative order-1 lg:order-2 mb-4 lg:mb-0">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-3xl opacity-30">
                    </div>
                    <div class="relative z-10 flex justify-center">
                        <img src="{{ asset('uploads/settings/hero-gadget.jpeg') }}" alt="Featured Smartphones"
                            class="w-3/4 sm:w-2/3 lg:w-full max-w-md mx-auto animate-float drop-shadow-2xl">
                    </div>

                    <!-- Floating badges for extra flair (optional) -->
                    <div
                        class="absolute top-10 right-0 lg:right-10 bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-3 py-2 text-white text-xs sm:text-sm hidden sm:block">
                        <i class="fas fa-star text-yellow-300 mr-1"></i> 50k+ Happy Customers
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2 md:mb-4">Shop by Category</h2>
            <p class="text-base md:text-xl text-gray-600">Find exactly what you're looking for</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
            @foreach ($categories as $category)
                <a href="{{ route('category', $category->slug) }}"
                    class="bg-gradient-to-br {{ $category->gradient ?? 'from-purple-500 to-indigo-500' }} rounded-xl md:rounded-2xl p-4 md:p-6 text-center hover:shadow-2xl transition transform hover:-translate-y-2 group">
                    <div
                        class="w-12 h-12 md:w-16 md:h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition">
                        @if ($category->icon)
                            <i class="{{ $category->icon }} text-xl md:text-3xl text-white"></i>
                        @else
                            <i class="fas fa-box text-xl md:text-3xl text-white"></i>
                        @endif
                    </div>
                    <h3 class="text-sm md:text-lg font-semibold text-white mb-1 truncate">{{ $category->name }}</h3>
                    <span class="text-xs md:text-sm text-white text-opacity-80">{{ $category->products_count }} items</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Hot Deals Section -->
    @if ($hotDeals->count() > 0)
        <section class="bg-gradient-to-r from-red-50 to-orange-50 py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 md:mb-12">
                    <div class="text-center sm:text-left mb-4 sm:mb-0">
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-fire text-red-500 mr-3"></i>Hot Deals
                        </h2>
                        <p class="text-sm md:text-xl text-gray-600">Limited time offers, grab them while they last!</p>
                    </div>
                    <a href="{{ route('shop', ['filter' => 'hot-deals']) }}"
                        class="text-red-600 hover:text-red-700 font-semibold flex items-center text-sm md:text-base">
                        View All <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                    @foreach ($hotDeals as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
            <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-8 text-center hover:shadow-xl transition">
                <div
                    class="w-12 h-12 md:w-20 md:h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-6">
                    <i class="fas fa-truck text-xl md:text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-sm md:text-xl font-semibold mb-2 md:mb-3">Free Delivery</h3>
                <p class="text-xs md:text-base text-gray-600">On orders above
                    @if (setting('free_shipping_enabled'))
                        ₦{{ number_format(setting('free_shipping_min_amount', 50000), 0) }}
                    @endif
                </p>
            </div>

            <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-8 text-center hover:shadow-xl transition">
                <div
                    class="w-12 h-12 md:w-20 md:h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-6">
                    <i class="fas fa-undo-alt text-xl md:text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-sm md:text-xl font-semibold mb-2 md:mb-3">7 Days Return</h3>
                <p class="text-xs md:text-base text-gray-600">Money-back guarantee</p>
            </div>

            <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-8 text-center hover:shadow-xl transition">
                <div
                    class="w-12 h-12 md:w-20 md:h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-6">
                    <i class="fas fa-lock text-xl md:text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-sm md:text-xl font-semibold mb-2 md:mb-3">Secure Payment</h3>
                <p class="text-xs md:text-base text-gray-600">100% secure transactions</p>
            </div>

            <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-8 text-center hover:shadow-xl transition">
                <div
                    class="w-12 h-12 md:w-20 md:h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-6">
                    <i class="fas fa-headset text-xl md:text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-sm md:text-xl font-semibold mb-2 md:mb-3">24/7 Support</h3>
                <p class="text-xs md:text-base text-gray-600">We're here to help</p>
            </div>
        </div>
    </div>

    <!-- New Arrivals Section -->
    @if ($newArrivals->count() > 0)
        <section class="py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 md:mb-12">
                    <div class="text-center sm:text-left mb-4 sm:mb-0">
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-clock text-green-500 mr-3"></i>New Arrivals
                        </h2>
                        <p class="text-sm md:text-xl text-gray-600">The latest products just dropped</p>
                    </div>
                    <a href="{{ route('shop', ['filter' => 'new-arrivals']) }}"
                        class="text-green-600 hover:text-green-700 font-semibold flex items-center text-sm md:text-base">
                        View All <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                    @foreach ($newArrivals as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Featured Brands -->
    <section class="bg-gray-100 py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center text-gray-900 mb-8 md:mb-12">Top Brands</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-8">
                <div
                    class="bg-white rounded-lg md:rounded-xl p-4 md:p-6 flex items-center justify-center hover:shadow-xl transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/120px-Apple_logo_black.svg.png"
                        alt="Apple" class="h-8 md:h-12">
                </div>
                <div
                    class="bg-white rounded-lg md:rounded-xl p-4 md:p-6 flex items-center justify-center hover:shadow-xl transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/61/Samsung_old_logo_before_year_2015.svg"
                        alt="Samsung" class="h-6 md:h-8">
                </div>
                <div
                    class="bg-white rounded-lg md:rounded-xl p-4 md:p-6 flex items-center justify-center hover:shadow-xl transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/88/Pixel_wordmark.svg"
                        alt="Google" class="h-6 md:h-8">
                </div>
                <div
                    class="bg-white rounded-lg md:rounded-xl p-4 md:p-6 flex items-center justify-center hover:shadow-xl transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/48/Xiaomi_logo_different_version.png"
                        alt="Xiaomi" class="h-6 md:h-8">
                </div>
                <div
                    class="bg-white rounded-lg md:rounded-xl p-4 md:p-6 flex items-center justify-center hover:shadow-xl transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/02/Nokia_wordmark.svg"
                        alt="Nokia" class="h-6 md:h-8">
                </div>
                <div
                    class="bg-white rounded-lg md:rounded-xl p-4 md:p-6 flex items-center justify-center hover:shadow-xl transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/33/Sony_Group_logo.svg"
                        alt="Sony" class="h-6 md:h-8">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center text-gray-900 mb-2 md:mb-4">What Our
                Customers Say</h2>
            <p class="text-base md:text-xl text-center text-gray-600 mb-8 md:mb-12">Join thousands of satisfied customers
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-6 md:p-8 hover:shadow-xl transition">
                    <div class="flex text-yellow-400 mb-3 md:mb-4">
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                    </div>
                    <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6">"Best gadget store in Nigeria! Fast delivery
                        and great customer service. Got my iPhone 13 in perfect condition."</p>
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-base md:text-xl">
                            JD</div>
                        <div class="ml-3 md:ml-4">
                            <h4 class="text-sm md:text-base font-semibold">Kayode Adesola</h4>
                            <p class="text-xs md:text-sm text-gray-500">Lagos</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-6 md:p-8 hover:shadow-xl transition">
                    <div class="flex text-yellow-400 mb-3 md:mb-4">
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                    </div>
                    <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6">"Amazing selection of products. The prices
                        are very competitive and the quality is top-notch. Highly recommended!"</p>
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-base md:text-xl">
                            SA</div>
                        <div class="ml-3 md:ml-4">
                            <h4 class="text-sm md:text-base font-semibold">Sarah Adebayo</h4>
                            <p class="text-xs md:text-sm text-gray-500">Abuja</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl md:rounded-2xl shadow-lg p-6 md:p-8 hover:shadow-xl transition md:col-span-2 lg:col-span-1">
                    <div class="flex text-yellow-400 mb-3 md:mb-4">
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                        <i class="fas fa-star text-sm md:text-base"></i>
                    </div>
                    <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6">"The WhatsApp checkout is so convenient!
                        Received my order within 2 days. Will definitely shop again."</p>
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-base md:text-xl">
                            MK</div>
                        <div class="ml-3 md:ml-4">
                            <h4 class="text-sm md:text-base font-semibold">Mike Okonkwo</h4>
                            <p class="text-xs md:text-sm text-gray-500">Port Harcourt</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Instagram Feed -->
    <section class="bg-gray-100 py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2">Follow Us on Instagram</h2>
                <a href="https://www.instagram.com/_dominiongadgets?igsh=MXExZWxyejk1ZWxscQ%3D%3D&utm_source=qr" 
                   target="_blank" 
                   class="inline-flex items-center text-purple-600 hover:text-purple-700 text-lg">
                    <i class="fab fa-instagram mr-2"></i>
                    @_dominiongadgets
                </a>
            </div>

            <!-- Elfsight Instagram Feed | Dominion -->
            <script src="https://elfsightcdn.com/platform.js" async></script>
            <div class="elfsight-app-20fc9aab-e5cc-42f7-ad5f-c798be64c76b" data-elfsight-app-lazy></div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
// Wishlist toggle function
function toggleWishlist(productId) {
    fetch('{{ route('wishlist.toggle') }}', {
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
            const icon = document.querySelector(`.wishlist-icon-${productId}`);
            if (data.added) {
                icon.classList.remove('far', 'text-gray-600');
                icon.classList.add('fas', 'text-red-500');
                showNotification('Added to wishlist', 'success');
            } else {
                icon.classList.remove('fas', 'text-red-500');
                icon.classList.add('far', 'text-gray-600');
                showNotification('Removed from wishlist', 'success');
            }
            updateWishlistCount(data.count);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating wishlist', 'error');
    });
}

// Add to cart function
function addToCart(productId) {
    fetch('{{ route('cart.add') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount(data.cartCount);
            showNotification('Product added to cart!', 'success');
        } else {
            showNotification(data.message || 'Error adding to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding to cart', 'error');
    });
}

// Update wishlist count in header
function updateWishlistCount(count) {
    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
    wishlistCountElements.forEach(el => {
        el.textContent = count;
        if (count > 0) {
            el.classList.remove('hidden');
        } else {
            el.classList.add('hidden');
        }
    });
}

// Update cart count in header
function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => {
        el.textContent = count;
    });
}

// Show notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-4 py-3 rounded-lg shadow-lg z-50 animate-slide-in ${
        type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transition = 'opacity 0.5s';
        notification.style.opacity = '0';
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 3000);
}

// Initialize wishlist buttons on page load
document.addEventListener('DOMContentLoaded', function() {
    // You can add any initialization here if needed
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
.animate-slide-in {
    animation: slideIn 0.3s ease-out;
}
</style>
@endpush