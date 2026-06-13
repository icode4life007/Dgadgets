@extends('layouts.app')

@section('title', 'Order Review - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-8">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('cart') }}" class="text-gray-500 hover:text-purple-600">Cart</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900">Order Review</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Review Your Order</h1>
                
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                    <div class="flex items-center space-x-4 border-b pb-4">
                        <img src="{{ asset($item['product']->main_image) }}" 
                             alt="{{ $item['product']->name }}"
                             class="w-20 h-20 object-cover rounded">
                        <div class="flex-1">
                            <h3 class="font-semibold">{{ $item['product']->name }}</h3>
                            <p class="text-sm text-gray-600">Quantity: {{ $item['quantity'] }}</p>
                            <p class="text-sm text-gray-600">Price: ₦{{ number_format($item['product']->price, 0) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-purple-600">₦{{ number_format($item['subtotal'], 0) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">₦{{ number_format($total, 0) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium">To be calculated</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between font-bold">
                            <span>Total</span>
                            <span class="text-xl text-purple-600">₦{{ number_format($total, 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Confirm Order Button -->
                <a href="{{ route('checkout') }}" 
                   class="block w-full bg-green-500 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition mb-3">
                    <i class="fab fa-whatsapp mr-2"></i>
                    Confirm Order 
                </a>

                <a href="{{ route('cart') }}" 
                   class="block w-full text-center text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Cart
                </a>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">WhatsApp Checkout Process</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>After clicking the confirm button:</p>
                    <ol class="list-decimal ml-5 mt-2 space-y-1">
                        <li>You'll be redirected to WhatsApp</li>
                        <li>Review your order details in the message</li>
                        <li>Add your name, phone number, and delivery address</li>
                        <li>Send the message to complete your order</li>
                        <li>Our team will confirm your order shortly</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection