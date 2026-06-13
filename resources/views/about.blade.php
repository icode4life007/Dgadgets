@extends('layouts.app')

@section('title', 'About Us - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">About Us</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-16 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">About Dominion Gadget & Accessories</h1>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto">Your trusted partner for quality gadgets and electronics since 2020</p>
        </div>

        <div class="p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Story</h2>
                    <p class="text-gray-600 mb-4">Dominion Gadget & Accessories was founded in 2020 with a simple mission: to provide Nigerians with access to high-quality gadgets at affordable prices. What started as a small online store has grown into one of the country's most trusted gadget retailers.</p>
                    <p class="text-gray-600">We believe that everyone deserves access to the latest technology without breaking the bank. That's why we carefully curate our product selection to offer the best value for money.</p>
                </div>
                <div class="bg-gray-100 rounded-xl p-8">
                    <img src="https://images.unsplash.com/photo-1556740714-a8395b3bf30f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Our Store" class="rounded-lg shadow-lg">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-box text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">10,000+ Products</h3>
                    <p class="text-gray-600">Wide selection of gadgets and accessories</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">50,000+ Customers</h3>
                    <p class="text-gray-600">Trusted by customers nationwide</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Fast Delivery</h3>
                    <p class="text-gray-600">Free shipping on orders above ₦50,000</p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-8 mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Our Values</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <i class="fas fa-shield-alt text-purple-600 text-2xl mb-3"></i>
                        <h3 class="font-semibold mb-2">Quality Assurance</h3>
                        <p class="text-sm text-gray-600">All products are thoroughly tested before sale</p>
                    </div>
                    <div>
                        <i class="fas fa-hand-holding-heart text-purple-600 text-2xl mb-3"></i>
                        <h3 class="font-semibold mb-2">Customer First</h3>
                        <p class="text-sm text-gray-600">Your satisfaction is our priority</p>
                    </div>
                    <div>
                        <i class="fas fa-lock text-purple-600 text-2xl mb-3"></i>
                        <h3 class="font-semibold mb-2">Secure Shopping</h3>
                        <p class="text-sm text-gray-600">Your data is always protected</p>
                    </div>
                    <div>
                        <i class="fas fa-leaf text-purple-600 text-2xl mb-3"></i>
                        <h3 class="font-semibold mb-2">Sustainability</h3>
                        <p class="text-sm text-gray-600">Committed to eco-friendly practices</p>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Ready to shop?</h2>
                <p class="text-gray-600 mb-6">Browse our collection of the latest gadgets and electronics</p>
                <a href="{{ route('shop') }}" class="inline-flex items-center px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                    Start Shopping
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection