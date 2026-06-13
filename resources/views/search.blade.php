@extends('layouts.app')

@section('title', 'Search Results - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">Search Results</span>
    </nav>

    <!-- Search Header -->
    <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Search Results</h1>
        <p class="text-gray-600">
            @if($query)
                Showing results for "{{ $query }}" - {{ $products->total() }} products found
            @else
                Please enter a search term
            @endif
        </p>
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
        {{ $products->withQueryString()->links() }}
    </div>
    @elseif($query)
    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Results Found</h3>
        <p class="text-gray-500 mb-6">We couldn't find any products matching "{{ $query }}"</p>
        <a href="{{ route('shop') }}" class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
            Browse All Products
        </a>
    </div>
    @endif
</div>
@endsection