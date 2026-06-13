@extends('layouts.app')

@section('title', 'Brands - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">Brands</span>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Shop by Brand</h1>
        <p class="text-gray-600 mt-2">Browse products from your favorite brands</p>
    </div>

    <!-- Brands Grid -->
    @if($brands->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($brands as $brand)
        <a href="{{ route('brand.show', Str::slug($brand)) }}" 
           class="bg-white rounded-lg shadow-sm p-6 text-center hover:shadow-md transition group">
            <div class="w-24 h-24 bg-gradient-to-br from-purple-50 to-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                <i class="fas fa-building text-3xl text-purple-600 group-hover:text-purple-700"></i>
            </div>
            <h3 class="font-semibold text-gray-800 text-lg mb-2">{{ $brand }}</h3>
            @php
                $productCount = App\Models\Product::where('brand', $brand)->where('is_active', true)->count();
            @endphp
            <p class="text-sm text-gray-500">{{ $productCount }} products</p>
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
        <i class="fas fa-tag text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Brands Found</h3>
        <p class="text-gray-500">Brands will appear here once products are added.</p>
    </div>
    @endif
</div>
@endsection