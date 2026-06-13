@extends('layouts.app')

@section('title', 'Sitemap - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">Sitemap</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Sitemap</h1>
            <p class="text-purple-100 text-lg">Navigate our website</p>
        </div>

        <div class="p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Main Pages</h2>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-purple-600 hover:text-purple-700">Home</a></li>
                        <li><a href="{{ route('shop') }}" class="text-purple-600 hover:text-purple-700">Shop</a></li>
                        <li><a href="{{ route('about') }}" class="text-purple-600 hover:text-purple-700">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-purple-600 hover:text-purple-700">Contact</a></li>
                        <!--<li><a href="{{ route('blog') }}" class="text-purple-600 hover:text-purple-700">Blog</a></li>-->
                        <li><a href="{{ route('brands') }}" class="text-purple-600 hover:text-purple-700">Brands</a></li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Shop Categories</h2>
                    <ul class="space-y-2">
                        <li><a href="{{ route('category', 'smartphones') }}" class="text-purple-600 hover:text-purple-700">Smartphones</a></li>
                        <li><a href="{{ route('category', 'laptops') }}" class="text-purple-600 hover:text-purple-700">Laptops</a></li>
                        <li><a href="{{ route('category', 'tablets') }}" class="text-purple-600 hover:text-purple-700">Tablets</a></li>
                        <li><a href="{{ route('category', 'accessories') }}" class="text-purple-600 hover:text-purple-700">Accessories</a></li>
                        <li><a href="{{ route('category', 'smart-watches') }}" class="text-purple-600 hover:text-purple-700">Smart Watches</a></li>
                        <li><a href="{{ route('category', 'audio') }}" class="text-purple-600 hover:text-purple-700">Audio</a></li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Service</h2>
                    <ul class="space-y-2">
                        <li><a href="{{ route('faqs') }}" class="text-purple-600 hover:text-purple-700">FAQs</a></li>
                        <li><a href="{{ route('shipping-policy') }}" class="text-purple-600 hover:text-purple-700">Shipping Policy</a></li>
                        <li><a href="{{ route('return-policy') }}" class="text-purple-600 hover:text-purple-700">Return Policy</a></li>
                        <!--<li><a href="{{ route('payment-methods') }}" class="text-purple-600 hover:text-purple-700">Payment Methods</a></li>-->
                        <li><a href="{{ route('privacy-policy') }}" class="text-purple-600 hover:text-purple-700">Privacy Policy</a></li>
                        <li><a href="{{ route('terms-of-service') }}" class="text-purple-600 hover:text-purple-700">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection