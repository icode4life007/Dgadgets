@extends('layouts.app')

@section('title', 'My Wishlist - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-8">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('shop') }}" class="text-gray-500 hover:text-purple-600">Shop</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">My Wishlist</span>
    </nav>

    <!-- Header with count -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">My Wishlist</h1>
            <p class="text-gray-600 text-sm mt-1">{{ $wishlist->count() }} {{ Str::plural('item', $wishlist->count()) }} saved</p>
        </div>
        
        @if($wishlist->count() > 0)
        <button onclick="clearWishlist()" 
                class="text-sm text-red-600 hover:text-red-700 transition flex items-center bg-red-50 px-4 py-2 rounded-lg">
            <i class="fas fa-trash-alt mr-2"></i>
            Clear Wishlist
        </button>
        @endif
    </div>

    @if($wishlist->count() > 0)
        <!-- Wishlist Items Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($wishlist as $item)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 wishlist-item group"
                     id="wishlist-item-{{ $item->product->id }}"
                     data-product-id="{{ $item->product->id }}">
                    
                    <!-- Product Image with Actions -->
                    <div class="relative overflow-hidden">
                        <a href="{{ route('product', $item->product->slug) }}">
                            <img src="{{ asset($item->product->main_image) }}" 
                                 alt="{{ $item->product->name }}"
                                 class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                        </a>
                        
                        <!-- Overlay Actions -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <div class="flex space-x-2">
                                <a href="{{ route('product', $item->product->slug) }}" 
                                   class="bg-white text-purple-600 p-3 rounded-full shadow-lg hover:bg-purple-600 hover:text-white transition transform hover:scale-110"
                                   title="View Product">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button onclick="removeFromWishlist({{ $item->product->id }})" 
                                        class="bg-white text-red-500 p-3 rounded-full shadow-lg hover:bg-red-500 hover:text-white transition transform hover:scale-110"
                                        title="Remove from Wishlist">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Discount Badge -->
                        @if($item->product->old_price && $item->product->old_price > $item->product->price)
                            @php
                                $discount = round((($item->product->old_price - $item->product->price) / $item->product->old_price) * 100);
                            @endphp
                            <span class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                -{{ $discount }}% OFF
                            </span>
                        @endif
                        
                        <!-- In Stock Badge -->
                        <span class="absolute top-3 right-3 {{ $item->product->quantity > 0 ? 'bg-green-500' : 'bg-gray-500' }} text-white text-xs px-3 py-1.5 rounded-full shadow-lg">
                            <i class="fas {{ $item->product->quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                            {{ $item->product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                    
                    <!-- Product Details -->
                    <div class="p-5">
                        <!-- Category -->
                        <div class="text-xs text-gray-500 mb-2 uppercase tracking-wider">
                            {{ $item->product->category->name ?? 'Uncategorized' }}
                        </div>
                        
                        <!-- Product Name -->
                        <a href="{{ route('product', $item->product->slug) }}" class="block">
                            <h3 class="text-sm font-semibold text-gray-800 hover:text-purple-600 mb-3 line-clamp-2 min-h-[40px]">
                                {{ $item->product->name }}
                            </h3>
                        </a>
                        
                        <!-- Rating -->
                        <div class="flex items-center mb-3">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($item->product->average_rating ?? 0))
                                        <i class="fas fa-star text-xs"></i>
                                    @else
                                        <i class="far fa-star text-xs text-gray-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-2">({{ $item->product->total_reviews ?? 0 }} reviews)</span>
                        </div>
                        
                        <!-- Price -->
                        <div class="flex items-baseline justify-between mb-4">
                            <div>
                                <span class="text-xl font-bold text-purple-600">₦{{ number_format($item->product->price, 0) }}</span>
                                @if($item->product->old_price && $item->product->old_price > $item->product->price)
                                    <span class="text-xs text-gray-400 line-through ml-2">₦{{ number_format($item->product->old_price, 0) }}</span>
                                @endif
                            </div>
                            
                            <!-- Remove Icon (Mobile visible) -->
                            <button onclick="removeFromWishlist({{ $item->product->id }})" 
                                    class="lg:hidden text-red-500 hover:text-red-700 transition p-2"
                                    title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('product', $item->product->slug) }}" 
                               class="flex items-center justify-center px-4 py-2.5 border-2 border-purple-600 text-purple-600 rounded-xl text-sm font-semibold hover:bg-purple-50 transition">
                                <i class="fas fa-info-circle mr-2"></i>
                                Details
                            </a>
                            
                            @if($item->product->quantity > 0)
                                <button onclick="addToCart({{ $item->product->id }})" 
                                        class="flex items-center justify-center px-4 py-2.5 bg-purple-600 text-white rounded-xl text-sm font-semibold hover:bg-purple-700 transition transform hover:scale-105">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Add to Cart
                                </button>
                            @else
                                <button disabled 
                                        class="flex items-center justify-center px-4 py-2.5 bg-gray-300 text-gray-500 rounded-xl text-sm font-semibold cursor-not-allowed">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Share Wishlist Section -->
        <div class="mt-12 bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center">
                    <div class="bg-purple-600 rounded-full p-4 mr-4">
                        <i class="fas fa-share-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Share Your Wishlist</h3>
                        <p class="text-gray-600">Let your friends and family know what you'd love to receive!</p>
                    </div>
                </div>
                
                <div class="flex space-x-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('wishlist')) }}" 
                       target="_blank"
                       class="bg-[#3b5998] text-white px-5 py-3 rounded-xl hover:bg-[#2d4373] transition flex items-center">
                        <i class="fab fa-facebook-f mr-2"></i>
                        Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=Check%20out%20my%20wishlist%20on%20Dominion%20Gadget!&url={{ urlencode(route('wishlist')) }}" 
                       target="_blank"
                       class="bg-[#1da1f2] text-white px-5 py-3 rounded-xl hover:bg-[#0c85d0] transition flex items-center">
                        <i class="fab fa-twitter mr-2"></i>
                        Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode('Check out my wishlist on Dominion Gadget & Accessories: ' . route('wishlist')) }}" 
                       target="_blank"
                       class="bg-[#25d366] text-white px-5 py-3 rounded-xl hover:bg-[#128C7E] transition flex items-center">
                        <i class="fab fa-whatsapp mr-2"></i>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>

    @else
        <!-- Empty Wishlist State -->
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center max-w-2xl mx-auto">
            <!-- Animated Heart Icon -->
            <div class="relative mb-8">
                <div class="absolute inset-0 bg-purple-100 rounded-full blur-xl opacity-70 animate-pulse"></div>
                <div class="relative bg-gradient-to-br from-purple-100 to-pink-100 w-32 h-32 mx-auto rounded-full flex items-center justify-center border-4 border-purple-200">
                    <i class="fas fa-heart text-6xl text-purple-400 animate-pulse"></i>
                </div>
                <div class="absolute -top-2 -right-2 w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center animate-bounce">
                    <i class="fas fa-star text-purple-600 text-sm"></i>
                </div>
                <div class="absolute -bottom-2 -left-2 w-8 h-8 bg-pink-200 rounded-full flex items-center justify-center animate-bounce" style="animation-delay: 0.2s">
                    <i class="fas fa-gift text-pink-600 text-sm"></i>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-3">Your Wishlist is Empty</h2>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Looks like you haven't added any items to your wishlist yet. 
                Discover amazing gadgets and save your favorites!
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('shop') }}" 
                   class="inline-flex items-center justify-center bg-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-purple-700 transition transform hover:scale-105 shadow-lg">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    Start Shopping
                </a>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center justify-center border-2 border-purple-600 text-purple-600 px-8 py-4 rounded-xl font-semibold hover:bg-purple-50 transition">
                    <i class="fas fa-home mr-2"></i>
                    Go Home
                </a>
            </div>

            <!-- Popular Categories -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-3">Popular Categories:</p>
                <div class="flex flex-wrap justify-center gap-2">
                    <a href="{{ route('category', 'smartphones') }}" class="text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full hover:bg-purple-100 hover:text-purple-600 transition">
                        Smartphones
                    </a>
                    <a href="{{ route('category', 'laptops') }}" class="text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full hover:bg-purple-100 hover:text-purple-600 transition">
                        Laptops
                    </a>
                    <a href="{{ route('category', 'tablets') }}" class="text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full hover:bg-purple-100 hover:text-purple-600 transition">
                        Tablets
                    </a>
                    <a href="{{ route('category', 'accessories') }}" class="text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full hover:bg-purple-100 hover:text-purple-600 transition">
                        Accessories
                    </a>
                    <a href="{{ route('category', 'audio') }}" class="text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full hover:bg-purple-100 hover:text-purple-600 transition">
                        Audio
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- JavaScript Functions -->
@push('scripts')
<script>
// Remove from wishlist function
function removeFromWishlist(productId) {
    if (confirm('Remove this item from your wishlist?')) {
        const item = document.getElementById(`wishlist-item-${productId}`);
        
        fetch('{{ route('wishlist.remove') }}', {
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
                item.style.transition = 'all 0.3s ease';
                item.style.opacity = '0';
                item.style.transform = 'scale(0.8)';
                
                setTimeout(() => {
                    item.remove();
                    updateWishlistCount(data.count);
                    
                    // Show notification
                    showNotification('Item removed from wishlist', 'success');
                    
                    // Check if wishlist is empty and reload page
                    if (document.querySelectorAll('.wishlist-item').length === 0) {
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                }, 300);
            } else {
                showNotification(data.message || 'Error removing item', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error removing item', 'error');
        });
    }
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

// Clear entire wishlist
function clearWishlist() {
    if (confirm('Are you sure you want to clear your entire wishlist? This action cannot be undone.')) {
        fetch('{{ route('wishlist.clear') }}', {
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
            } else {
                showNotification(data.message || 'Error clearing wishlist', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error clearing wishlist', 'error');
        });
    }
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

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide notifications after 5 seconds
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
</script>
@endpush

@push('styles')
<style>
/* Slide in animation for notifications */
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

/* Hover effects for wishlist items */
.wishlist-item {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.wishlist-item:hover {
    box-shadow: 0 20px 25px -5px rgba(93, 63, 211, 0.1), 0 10px 10px -5px rgba(93, 63, 211, 0.04);
}

/* Line clamp for product names */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Heart beat animation */
@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.fa-heart {
    animation: heartBeat 1.5s ease-in-out infinite;
}
</style>
@endpush
@endsection