@extends('admin.layouts.admin')

@section('title', 'View Product')
@section('page-title', 'Product Details')
@section('page-subtitle', $product->name)
@section('page-icon', 'fa-eye')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header with Actions -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 gradient-bg-primary rounded-xl flex items-center justify-center">
                        <i class="fas fa-box text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="text-sm text-gray-500">
                                <i class="far fa-clock mr-1"></i>Created: {{ $product->created_at->format('M d, Y') }}
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="far fa-edit mr-1"></i>Updated: {{ $product->updated_at->format('M d, Y') }}
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="far fa-eye mr-1"></i>{{ number_format($product->views) }} views
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap items-center gap-2">
                    <!-- Status Toggle -->
                    <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="inline">
                        @csrf
                        @method('POST')
                        <button type="submit" 
                                class="px-4 py-2 {{ $product->is_active ? 'bg-green-100 text-green-600 hover:bg-green-200' : 'bg-red-100 text-red-600 hover:bg-red-200' }} rounded-lg transition flex items-center">
                            <i class="fas {{ $product->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-2"></i>
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.products.edit', $product) }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                        <i class="fas fa-edit mr-2"></i> Edit Product
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats Bar -->
        <div class="bg-gray-50 px-6 py-4 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Price</p>
                <p class="text-lg font-bold text-gray-800">₦{{ number_format($product->price, 0) }}</p>
                @if($product->tax > 0)
                    <p class="text-xs text-green-600">+{{ $product->tax }}% tax inclusive</p>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Stock</p>
                <p class="text-lg font-bold {{ $product->quantity > 10 ? 'text-green-600' : ($product->quantity > 0 ? 'text-orange-600' : 'text-red-600') }}">
                    {{ number_format($product->quantity) }} units
                </p>
                @if($product->quantity < 10 && $product->quantity > 0)
                    <p class="text-xs text-orange-600">Low stock</p>
                @elseif($product->quantity == 0)
                    <p class="text-xs text-red-600">Out of stock</p>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Category</p>
                <a href="{{ route('admin.categories.show', $product->category) }}" class="text-lg font-bold text-purple-600 hover:text-purple-700">
                    {{ $product->category->name }}
                </a>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">SKU</p>
                <p class="text-lg font-bold text-gray-800">#{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Images -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-images text-purple-600 mr-2"></i>
                        Product Images
                    </h4>
                </div>
                
                <div class="p-6">
                    <!-- Main Image -->
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-700 mb-3">Main Image</p>
                        <div class="relative group inline-block">
                            <img src="{{ asset($product->main_image) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full max-w-md h-auto object-cover rounded-xl border-2 border-gray-200 group-hover:border-purple-500 transition">
                            <a href="{{ asset($product->main_image) }}" 
                               target="_blank"
                               class="absolute top-4 right-4 bg-white bg-opacity-90 p-2 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition hover:bg-purple-600 hover:text-white">
                                <i class="fas fa-search-plus"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Gallery Images -->
                    @if($product->gallery_images)
                        @php
                            $galleryImages = is_array($product->gallery_images) ? $product->gallery_images : (json_decode($product->gallery_images, true) ?? []);
                        @endphp
                        
                        @if(count($galleryImages) > 0)
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-3">Gallery Images ({{ count($galleryImages) }})</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    @foreach($galleryImages as $index => $image)
                                        <div class="relative group">
                                            <img src="{{ asset($image) }}" 
                                                 alt="Gallery image {{ $index + 1 }}"
                                                 class="w-full h-24 object-cover rounded-lg border border-gray-200 group-hover:border-purple-500 transition">
                                            <a href="{{ asset($image) }}" 
                                               target="_blank"
                                               class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                <i class="fas fa-eye text-white"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Description Section -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6">
                <div class="p-6 border-b border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-align-left text-purple-600 mr-2"></i>
                        Product Description
                    </h4>
                </div>
                
                <div class="p-6">
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Product Details -->
        <div class="lg:col-span-1">
            <!-- Basic Information Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                        Basic Information
                    </h4>
                </div>
                
                <div class="p-6">
                    <dl class="space-y-4">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Product ID</dt>
                            <dd class="text-sm font-medium text-gray-900">#{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</dd>
                        </div>
                        
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Category</dt>
                            <dd class="text-sm font-medium">
                                <a href="{{ route('admin.categories.show', $product->category) }}" 
                                   class="text-purple-600 hover:text-purple-700">
                                    {{ $product->category->name }}
                                </a>
                            </dd>
                        </div>
                        
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Brand</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $product->brand ?? 'N/A' }}</dd>
                        </div>
                        
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Model</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $product->model ?? 'N/A' }}</dd>
                        </div>
                        
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Price</dt>
                            <dd class="text-sm font-medium text-gray-900">
                                ₦{{ number_format($product->price, 0) }}
                                @if($product->tax > 0)
                                    <span class="text-xs text-green-600">(+{{ $product->tax }}% tax)</span>
                                @endif
                            </dd>
                        </div>
                        
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Final Price</dt>
                            <dd class="text-sm font-bold text-purple-600">₦{{ number_format($product->final_price, 0) }}</dd>
                        </div>
                        
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Quantity</dt>
                            <dd class="text-sm font-medium">
                                <span class="{{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($product->quantity) }} units
                                </span>
                            </dd>
                        </div>
                        
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Views</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ number_format($product->views) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Product Flags Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6">
                <div class="p-6 border-b border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-flag text-purple-600 mr-2"></i>
                        Product Flags
                    </h4>
                </div>
                
                <div class="p-6">
                    <div class="space-y-3">
                        @if($product->is_hot_deal)
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-fire text-red-500 mr-3"></i>
                                    <span class="text-sm font-medium text-red-700">Hot Deal</span>
                                </div>
                                <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded-full">Active</span>
                            </div>
                        @endif
                        
                        @if($product->is_new_arrival)
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-green-500 mr-3"></i>
                                    <span class="text-sm font-medium text-green-700">New Arrival</span>
                                </div>
                                <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full">Active</span>
                            </div>
                        @endif
                        
                        @if($product->is_featured)
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-500 mr-3"></i>
                                    <span class="text-sm font-medium text-yellow-700">Featured</span>
                                </div>
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-600 text-xs rounded-full">Active</span>
                            </div>
                        @endif
                        
                        @if(!$product->is_hot_deal && !$product->is_new_arrival && !$product->is_featured)
                            <p class="text-sm text-gray-500 text-center py-4">No special flags assigned</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6">
                <div class="p-6 border-b border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-chart-line text-purple-600 mr-2"></i>
                        Statistics
                    </h4>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">View count</span>
                                <span class="font-medium text-gray-900">{{ number_format($product->views) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 rounded-full h-2" style="width: {{ min(100, ($product->views / 1000) * 100) }}%"></div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-purple-600">{{ $product->reviews_count ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Reviews</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-yellow-600">{{ number_format($product->average_rating ?? 0, 1) }}</p>
                                <p class="text-xs text-gray-500">Avg. Rating</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-between text-xs text-gray-500 pt-4 border-t border-gray-100">
                            <span>Created: {{ $product->created_at->format('M d, Y H:i A') }}</span>
                            <span>Updated: {{ $product->updated_at->format('M d, Y H:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Danger Zone (Delete) -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6 border-2 border-red-200">
        <div class="p-6 bg-red-50 border-b border-red-200">
            <h4 class="text-lg font-semibold text-red-600 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Danger Zone
            </h4>
        </div>
        
        <div class="p-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <p class="font-medium text-gray-900">Delete this product</p>
                    <p class="text-sm text-gray-500">Once deleted, this action cannot be undone. All associated data will be permanently removed.</p>
                </div>
                
                <form action="{{ route('admin.products.destroy', $product) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center whitespace-nowrap">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection