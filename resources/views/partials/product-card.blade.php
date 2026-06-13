<div class="bg-white rounded-lg shadow-md overflow-hidden product-card relative group">
    <!-- Wishlist Button -->
    <button onclick="toggleWishlist({{ $product->id }})" 
            class="absolute top-2 right-2 z-10 bg-white rounded-full p-2 shadow-md hover:bg-red-50 transition wishlist-btn-{{ $product->id }}"
            data-product-id="{{ $product->id }}">
        <i class="far fa-heart text-gray-600 hover:text-red-500 transition wishlist-icon-{{ $product->id }}"></i>
    </button>

    <a href="{{ route('product', $product->slug) }}" class="block relative">
        <div class="aspect-w-1 aspect-h-1">
            <img src="{{ asset($product->main_image) }}" 
                 alt="{{ $product->name }}"
                 class="w-full h-48 object-cover">
        </div>
        
        @if($product->is_hot_deal)
            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                Hot Deal
            </span>
        @endif
        
        @if($product->is_new_arrival)
            <span class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                New Arrival
            </span>
        @endif

        <!-- Low Stock Badge -->
        @if($product->quantity > 0 && $product->quantity <= 5)
            <span class="absolute bottom-2 left-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full">
                Only {{ $product->quantity }} left
            </span>
        @endif
    </a>
    
    <div class="p-4">
        <div class="text-xs text-gray-500 mb-1">
            @if($product->is_hot_deal)
                <a href="{{ route('category', 'hot-deals') }}" class="hover:text-purple-600">Hot Deals</a>
            @elseif($product->is_new_arrival)
                <a href="{{ route('category', 'new-arrivals') }}" class="hover:text-purple-600">New Arrivals</a>
            @else
                <a href="{{ route('category', $product->category->slug) }}" class="hover:text-purple-600">
                    {{ $product->category->name ?? 'Uncategorized' }}
                </a>
            @endif
        </div>
        
        <a href="{{ route('product', $product->slug) }}" class="block">
            <h3 class="text-sm font-medium text-gray-900 mb-2 hover:text-purple-600 line-clamp-2">
                {{ $product->name }}
            </h3>
        </a>
        
        <!-- Rating -->
        <div class="flex items-center mb-2">
            <div class="flex text-yellow-400">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= ($product->average_rating ?? 0))
                        <i class="fas fa-star text-xs"></i>
                    @else
                        <i class="far fa-star text-xs text-gray-300"></i>
                    @endif
                @endfor
            </div>
            <span class="text-xs text-gray-500 ml-1">({{ $product->total_reviews ?? 0 }})</span>
        </div>
        
        <!-- Price and Stock -->
        <div class="flex justify-between items-center mb-3">
            <div>
                <span class="text-lg font-bold text-purple-600">
                    ₦{{ number_format($product->price, 0) }}
                </span>
                @if($product->old_price && $product->old_price > $product->price)
                    <span class="text-xs text-gray-400 line-through ml-2">₦{{ number_format($product->old_price, 0) }}</span>
                @endif
            </div>
            
            <!-- Stock Status with Quantity -->
            <span class="text-xs {{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }} flex items-center">
                <i class="fas {{ $product->quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                @if($product->quantity > 0)
                    {{ $product->quantity }} in stock
                @else
                    Out of Stock
                @endif
            </span>
        </div>
        
        <!-- Action Buttons -->
        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('product', $product->slug) }}" 
               class="text-center px-3 py-2 border border-purple-600 text-purple-600 rounded-lg text-sm hover:bg-purple-50 transition">
                View
            </a>
            
            @if($product->quantity > 0)
                <button onclick="addToCart({{ $product->id }})" 
                        class="text-center px-3 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700 transition flex items-center justify-center">
                    <i class="fas fa-shopping-cart mr-1"></i> Add
                </button>
            @else
                <button disabled 
                        class="text-center px-3 py-2 bg-gray-300 text-gray-500 rounded-lg text-sm cursor-not-allowed">
                    Out of Stock
                </button>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleWishlist(productId) {
    const btn = document.querySelector(`.wishlist-btn-${productId}`);
    const icon = document.querySelector(`.wishlist-icon-${productId}`);
    
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

function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => {
        el.textContent = count;
    });
}
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