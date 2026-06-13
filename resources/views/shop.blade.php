@extends('layouts.app')

@section('title', 'Shop - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        @if(request('filter') == 'hot-deals')
            <span class="text-gray-900 font-medium">Hot Deals</span>
        @elseif(request('filter') == 'new-arrivals')
            <span class="text-gray-900 font-medium">New Arrivals</span>
        @else
            <span class="text-gray-900 font-medium">Shop</span>
        @endif
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                <h3 class="text-lg font-semibold mb-4">Filters</h3>
                
                <!-- Search Filter -->
                <div class="mb-6">
                    <form action="{{ route('shop') }}" method="GET" id="filterForm">
                        <!-- Preserve sort and filter parameters -->
                        @if(request()->has('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if(request()->has('filter'))
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                        @endif
                        
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search products..." 
                                   class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                            <button type="submit" class="absolute right-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Category Filter - Always Open -->
                <div class="mb-6" x-data="{ open: true }">
                    <h4 @click="open = !open" 
                        class="font-medium mb-3 flex items-center justify-between cursor-pointer hover:text-purple-600">
                        Category
                        <i class="fas fa-chevron-down text-sm transition-transform duration-200" 
                           :class="{ 'rotate-0': open, '-rotate-90': !open }"></i>
                    </h4>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($categories as $category)
                        <label class="flex items-center {{ request('category') == $category->slug ? 'bg-purple-50 rounded-lg p-2 -mx-2' : '' }}">
                            <input type="radio" 
                                   name="category" 
                                   value="{{ $category->slug }}"
                                   form="filterForm"
                                   {{ request('category') == $category->slug ? 'checked' : '' }}
                                   onchange="this.form.submit()"
                                   class="mr-2 text-purple-600 focus:ring-purple-500">
                            <span class="text-sm {{ request('category') == $category->slug ? 'font-semibold text-purple-600' : 'text-gray-600' }}">
                                {{ $category->name }}
                            </span>
                            @if(request('category') == $category->slug)
                            <a href="{{ route('shop', request()->except('category', 'page')) }}" class="ml-auto text-purple-600 hover:text-purple-800">
                                <i class="fas fa-times text-xs"></i>
                            </a>
                            @endif
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="mb-6" x-data="{ open: {{ request()->has('min_price') || request()->has('max_price') ? 'true' : 'false' }} }">
                    <h4 @click="open = !open" 
                        class="font-medium mb-3 flex items-center justify-between cursor-pointer hover:text-purple-600">
                        Price
                        <i class="fas fa-chevron-down text-sm transition-transform duration-200" 
                           :class="{ 'rotate-0': open, '-rotate-90': !open }"></i>
                    </h4>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2">
                        <div class="flex items-center gap-2 mb-4">
                            <input type="number" 
                                   name="min_price" 
                                   form="filterForm"
                                   value="{{ request('min_price', '') }}"
                                   placeholder="Min"
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                            <span>-</span>
                            <input type="number" 
                                   name="max_price" 
                                   form="filterForm"
                                   value="{{ request('max_price', '') }}"
                                   placeholder="Max"
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                        </div>
                        <button type="submit" 
                                form="filterForm"
                                class="w-full bg-purple-600 text-white py-2 rounded-lg text-sm hover:bg-purple-700 transition">
                            Apply Price
                        </button>
                    </div>
                </div>

                <!-- Tags Filter -->
                <div class="mb-6" x-data="{ open: {{ request('tag') ? 'true' : 'false' }} }">
                    <h4 @click="open = !open" 
                        class="font-medium mb-3 flex items-center justify-between cursor-pointer hover:text-purple-600">
                        Tag
                        <i class="fas fa-chevron-down text-sm transition-transform duration-200" 
                           :class="{ 'rotate-0': open, '-rotate-90': !open }"></i>
                    </h4>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <a href="{{ route('shop', array_merge(request()->except('tag', 'page'), ['tag' => $tag])) }}" 
                           class="px-3 py-1 text-sm {{ request('tag') == $tag ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full transition">
                            {{ $tag }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Clear Filters -->
                @if(request()->anyFilled(['category', 'search', 'min_price', 'max_price', 'tag', 'filter']))
                <a href="{{ route('shop') }}" 
                   class="block text-center text-purple-600 hover:text-purple-700 text-sm font-medium mt-4">
                    <i class="fas fa-times mr-1"></i> Clear All Filters
                </a>
                @endif
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:w-3/4">
            <!-- Shop Header -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            @if(request('filter') == 'hot-deals')
                                Hot Deals
                            @elseif(request('filter') == 'new-arrivals')
                                New Arrivals
                            @else
                                Shop
                            @endif
                        </h1>
                        <p class="text-gray-600 text-sm mt-1">
                            Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                        </p>
                    </div>

                    <!-- Sorting Dropdown - Fixed to preserve filters -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none">
                            <span class="text-sm">
                                @switch(request('sort', 'default'))
                                    @case('popularity') Sort by popularity @break
                                    @case('latest') Sort by latest @break
                                    @case('price_low') Sort by price: low to high @break
                                    @case('price_high') Sort by price: high to low @break
                                    @default Default sorting
                                @endswitch
                            </span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" 
                               :class="{ 'rotate-180': open }"></i>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border py-2 z-50">
                            
                            <!-- Build URL with all current filters + sort -->
                            @php
                                $baseParams = request()->except('sort', 'page');
                            @endphp
                            
                            <a href="{{ route('shop', $baseParams) }}" 
                               class="block px-4 py-2 text-sm {{ !request('sort') ? 'bg-purple-50 text-purple-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Default sorting
                            </a>
                            <a href="{{ route('shop', array_merge($baseParams, ['sort' => 'popularity'])) }}" 
                               class="block px-4 py-2 text-sm {{ request('sort') == 'popularity' ? 'bg-purple-50 text-purple-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Sort by popularity
                            </a>
                            <a href="{{ route('shop', array_merge($baseParams, ['sort' => 'latest'])) }}" 
                               class="block px-4 py-2 text-sm {{ request('sort') == 'latest' ? 'bg-purple-50 text-purple-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Sort by latest
                            </a>
                            <a href="{{ route('shop', array_merge($baseParams, ['sort' => 'price_low'])) }}" 
                               class="block px-4 py-2 text-sm {{ request('sort') == 'price_low' ? 'bg-purple-50 text-purple-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Sort by price: low to high
                            </a>
                            <a href="{{ route('shop', array_merge($baseParams, ['sort' => 'price_high'])) }}" 
                               class="block px-4 py-2 text-sm {{ request('sort') == 'price_high' ? 'bg-purple-50 text-purple-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Sort by price: high to low
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Active Filters Display -->
                @if(request()->anyFilled(['category', 'search', 'min_price', 'max_price', 'tag', 'filter']))
                <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-200">
                    @if(request('filter') == 'hot-deals')
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-600 text-sm rounded-full">
                        <i class="fas fa-fire mr-1"></i> Hot Deals
                        <a href="{{ route('shop', request()->except('filter', 'page')) }}" class="ml-2 hover:text-purple-800">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    
                    @if(request('filter') == 'new-arrivals')
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-600 text-sm rounded-full">
                        <i class="fas fa-clock mr-1"></i> New Arrivals
                        <a href="{{ route('shop', request()->except('filter', 'page')) }}" class="ml-2 hover:text-purple-800">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    
                    @if(request('search'))
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-600 text-sm rounded-full">
                        <i class="fas fa-search mr-1"></i> "{{ request('search') }}"
                        <a href="{{ route('shop', request()->except('search', 'page')) }}" class="ml-2 hover:text-purple-800">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    
                    @if(request('category'))
                    @php
                        $category = $categories->firstWhere('slug', request('category'));
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-600 text-sm rounded-full">
                        <i class="fas fa-folder mr-1"></i> {{ $category ? $category->name : request('category') }}
                        <a href="{{ route('shop', request()->except('category', 'page')) }}" class="ml-2 hover:text-purple-800">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    
                    @if(request('tag'))
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-600 text-sm rounded-full">
                        <i class="fas fa-tag mr-1"></i> {{ request('tag') }}
                        <a href="{{ route('shop', request()->except('tag', 'page')) }}" class="ml-2 hover:text-purple-800">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    
                    @if(request('min_price') || request('max_price'))
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-600 text-sm rounded-full">
                        <i class="fas fa-money-bill mr-1"></i> ₦{{ number_format(request('min_price', 0)) }} - ₦{{ number_format(request('max_price', 0)) }}
                        <a href="{{ route('shop', request()->except(['min_price', 'max_price', 'page'])) }}" class="ml-2 hover:text-purple-800">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                </div>
                @endif
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->withQueryString()->links() }}
            </div>
            @else
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Products Found</h3>
                <p class="text-gray-500 mb-6">Try adjusting your filters or search criteria</p>
                <a href="{{ route('shop') }}" class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                    Clear All Filters
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-submit form when radio changes
document.querySelectorAll('input[type="radio"][name="category"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});

// Add loading state to filter buttons
document.querySelector('button[type="submit"][form="filterForm"]')?.addEventListener('click', function() {
    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Applying...';
    this.disabled = true;
});
</script>
@endpush

@push('styles')
<style>
/* Smooth transitions for collapsible sections */
[x-cloak] { display: none !important; }

/* Custom scrollbar for category list */
.max-h-60::-webkit-scrollbar {
    width: 6px;
}

.max-h-60::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.max-h-60::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 10px;
}

.max-h-60::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}
</style>
@endpush
@endsection