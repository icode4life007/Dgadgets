@extends('layouts.app')

@section('title', 'Checkout - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-4 sm:mb-8">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('cart') }}" class="text-gray-500 hover:text-purple-600">Cart</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900">Checkout</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Complete Your Order</h1>
                
                <form id="checkoutForm" onsubmit="submitCheckout(event)" class="space-y-4 sm:space-y-6">
                    @csrf
                    
                    <!-- Customer Information -->
                    <div class="border-b pb-4 sm:pb-6">
                        <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Customer Information</h2>
                        
                        <div class="space-y-3 sm:space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="full_name" 
                                       name="full_name" 
                                       value="{{ old('full_name') }}"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 @error('full_name') border-red-500 @enderror"
                                       placeholder="Enter your full name"
                                       required>
                                <p class="text-xs text-red-500 hidden mt-1" id="name_error">Please enter your full name</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 @error('phone') border-red-500 @enderror"
                                       placeholder="e.g., 08012345678"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Enter a valid Nigerian phone number</p>
                                <p class="text-xs text-red-500 hidden mt-1" id="phone_error">Please enter your phone number</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Delivery Address <span class="text-red-500">*</span>
                                </label>
                                <textarea id="address" 
                                          name="address" 
                                          rows="3"
                                          class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 @error('address') border-red-500 @enderror"
                                          placeholder="Enter your full delivery address (including landmark, city, state)"
                                          required>{{ old('address') }}</textarea>
                                <p class="text-xs text-red-500 hidden mt-1" id="address_error">Please enter your delivery address</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email (Optional)
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                                       placeholder="Enter your email for order updates">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Additional Notes (Optional)
                                </label>
                                <textarea id="notes" 
                                          name="notes" 
                                          rows="2"
                                          class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                                          placeholder="Any special instructions?">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Review -->
                    <div>
                        <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Order Summary</h2>
                        
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($cartItems as $item)
                            <div class="flex items-center space-x-3 sm:space-x-4 border-b pb-3 sm:pb-4">
                                <img src="{{ asset($item['product']->main_image) }}" 
                                     alt="{{ $item['product']->name }}"
                                     class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded">
                                <div class="flex-1">
                                    <h3 class="text-sm sm:text-base font-semibold">{{ $item['product']->name }}</h3>
                                    <p class="text-xs sm:text-sm text-gray-600">Quantity: {{ $item['quantity'] }}</p>
                                    <p class="text-xs sm:text-sm text-gray-600">Price: ₦{{ number_format($item['product']->price, 0) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm sm:text-base font-semibold text-purple-600">₦{{ number_format($item['subtotal'], 0) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-4 sm:p-6 sticky top-4">
                <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Order Summary</h2>
                
                <div class="space-y-2 sm:space-y-3 mb-4 sm:mb-6">
                    <div class="flex justify-between text-xs sm:text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">₦{{ number_format($total, 0) }}</span>
                    </div>
                    <div class="flex justify-between text-xs sm:text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium">To be calculated</span>
                    </div>
                    <div class="border-t pt-2 sm:pt-3">
                        <div class="flex justify-between font-bold">
                            <span class="text-sm sm:text-base">Total</span>
                            <span class="text-base sm:text-xl text-purple-600">₦{{ number_format($total, 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Confirm Order Button -->
                <button onclick="submitCheckout(event)" 
                        class="w-full bg-green-500 text-white text-center px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-sm sm:text-base font-semibold hover:bg-green-600 transition mb-2 sm:mb-3 flex items-center justify-center">
                    <i class="fab fa-whatsapp mr-2"></i>
                    Confirm & Submit Order
                </button>

                <a href="{{ route('cart') }}" 
                   class="block w-full text-center text-gray-600 hover:text-gray-800 text-xs sm:text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Cart
                </a>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="mt-6 sm:mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 text-lg sm:text-xl"></i>
            </div>
            <div class="ml-2 sm:ml-3">
                <h3 class="text-xs sm:text-sm font-medium text-blue-800">Important Information</h3>
                <div class="mt-1 sm:mt-2 text-xs sm:text-sm text-blue-700">
                    <p>By clicking the WhatsApp button:</p>
                    <ul class="list-disc ml-4 sm:ml-5 mt-1 sm:mt-2 space-y-0.5 sm:space-y-1">
                        <li>You'll be redirected to WhatsApp with your complete order details</li>
                        <li>Your contact information will be included for delivery</li>
                        <li>Our team will confirm your order and provide payment details</li>
                        <li>Please ensure all information is correct before sending</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Prevent zoom on input focus for mobile */
    @media screen and (max-width: 768px) {
        input, select, textarea {
            font-size: 16px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function submitCheckout(event) {
    event.preventDefault();
    
    // Get form values
    const fullName = document.getElementById('full_name').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const address = document.getElementById('address').value.trim();
    
    // Validation
    let isValid = true;
    
    // Reset error messages
    document.getElementById('name_error').classList.add('hidden');
    document.getElementById('phone_error').classList.add('hidden');
    document.getElementById('address_error').classList.add('hidden');
    
    // Validate name
    if (!fullName) {
        document.getElementById('name_error').classList.remove('hidden');
        document.getElementById('full_name').classList.add('border-red-500');
        isValid = false;
    } else {
        document.getElementById('full_name').classList.remove('border-red-500');
    }
    
    // Validate phone
    if (!phone) {
        document.getElementById('phone_error').classList.remove('hidden');
        document.getElementById('phone').classList.add('border-red-500');
        isValid = false;
    } else {
        // Basic Nigerian phone validation
        const phoneRegex = /^(0|234)[7-9][0-9]{9}$|^[7-9][0-9]{9}$/;
        if (!phoneRegex.test(phone.replace(/\s/g, ''))) {
            document.getElementById('phone_error').textContent = 'Please enter a valid Nigerian phone number';
            document.getElementById('phone_error').classList.remove('hidden');
            document.getElementById('phone').classList.add('border-red-500');
            isValid = false;
        } else {
            document.getElementById('phone').classList.remove('border-red-500');
        }
    }
    
    // Validate address
    if (!address) {
        document.getElementById('address_error').classList.remove('hidden');
        document.getElementById('address').classList.add('border-red-500');
        isValid = false;
    } else {
        document.getElementById('address').classList.remove('border-red-500');
    }
    
    if (!isValid) {
        // Scroll to first error
        const firstError = document.querySelector('.border-red-500');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
    }
    
    // Show loading state
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
    button.disabled = true;
    
    // Prepare data
    const requestData = {
        full_name: fullName,
        phone: phone,
        address: address,
        email: document.getElementById('email').value.trim(),
        notes: document.getElementById('notes').value.trim()
    };
    
    console.log('Sending request:', requestData);
    
    // Send data to server to generate WhatsApp URL
    fetch('{{ route("checkout.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Open WhatsApp in a new tab
            window.open(data.whatsapp_url, '_blank');
            
            // Redirect to confirmation page
            window.location.href = data.redirect_url;
        } else {
            alert(data.message || 'Error processing order');
            button.innerHTML = originalText;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error details:', error);
        
        // Show more detailed error message
        let errorMessage = 'An error occurred. Please try again.';
        
        if (error.message) {
            errorMessage = error.message;
        } else if (error.errors) {
            errorMessage = Object.values(error.errors).flat().join('\n');
        } else if (error.exception) {
            errorMessage = error.message || 'Server error';
        }
        
        alert('Error: ' + errorMessage);
        
        button.innerHTML = originalText;
        button.disabled = false;
    });
}
</script>
@endpush
@endsection