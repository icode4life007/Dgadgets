@extends('layouts.app')

@section('title', $category->name . ' - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('shop') }}" class="text-gray-500 hover:text-purple-600">Shop</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">{{ $category->name }}</span>
    </nav>

    <!-- Category Header -->
    <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
        <div class="flex items-center">
            @if(isset($category->icon))
                <i class="{{ $category->icon }} text-4xl text-purple-600 mr-4"></i>
            @else
                <i class="fas fa-box text-4xl text-purple-600 mr-4"></i>
            @endif
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                @if(isset($category->description))
                    <p class="text-gray-600 mt-2">{{ $category->description }}</p>
                @endif
                <p class="text-gray-500 text-sm mt-2">
                    Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </p>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            @include('partials.product-card', ['product' => $product])
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
        <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Products Found</h3>
        <p class="text-gray-500 mb-6">There are no products in this category yet.</p>
        <a href="{{ route('shop') }}" class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
            Browse All Products
        </a>
    </div>
    @endif
</div>
@endsection