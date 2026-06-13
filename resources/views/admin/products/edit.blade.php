@extends('admin.layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product: ' . $product->name)

@section('content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold">Edit Product Information</h3>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $product->name) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 @error('category_id') border-red-500 @enderror"
                        required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                <input type="text" 
                       name="brand" 
                       value="{{ old('brand', $product->brand) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                <input type="text" 
                       name="model" 
                       value="{{ old('model', $product->model) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
            </div>

            <!-- Pricing -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price (₦) *</label>
                <input type="number" 
                       name="price" 
                       value="{{ old('price', $product->price) }}"
                       min="0"
                       step="0.01"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 @error('price') border-red-500 @enderror"
                       required>
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tax (%)</label>
                <input type="number" 
                       name="tax" 
                       value="{{ old('tax', $product->tax) }}"
                       min="0"
                       max="100"
                       step="0.1"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                <input type="number" 
                       name="quantity" 
                       value="{{ old('quantity', $product->quantity) }}"
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 @error('quantity') border-red-500 @enderror"
                       required>
                @error('quantity')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Main Image</label>
                <input type="file" 
                       name="main_image" 
                       accept="image/jpeg,image/png,image/jpg"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                @if($product->main_image)
                    <div class="mt-2">
                        <img src="{{ asset($product->main_image) }}" alt="Current" class="w-20 h-20 object-cover rounded">
                    </div>
                @endif
                @error('main_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gallery Images</label>
                <input type="file" 
                       name="gallery_images[]" 
                       multiple
                       accept="image/jpeg,image/png,image/jpg"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                <p class="text-xs text-gray-500 mt-1">Upload new images to replace existing ones</p>
                @if($product->gallery_images)
                    <div class="flex gap-2 mt-2">
                        @foreach($product->gallery_images as $image)
                            <img src="{{ asset($image) }}" alt="Gallery" class="w-16 h-16 object-cover rounded">
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Flags -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-3">Product Flags</label>
                <div class="flex space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_hot_deal" value="1" {{ old('is_hot_deal', $product->is_hot_deal) ? 'checked' : '' }}
                               class="mr-2 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm text-gray-700">Hot Deal</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}
                               class="mr-2 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm text-gray-700">New Arrival</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                               class="mr-2 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm text-gray-700">Featured</span>
                    </label>
                </div>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" 
                          rows="6"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 @error('description') border-red-500 @enderror"
                          required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex items-center space-x-3">
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                Update Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection