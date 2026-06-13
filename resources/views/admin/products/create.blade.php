@extends('admin.layouts.admin')

@section('title', 'Create Product')
@section('page-title', 'Create New Product')
@section('page-subtitle', 'Add a new product to your inventory')
@section('page-icon', 'fa-plus-circle')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Form Header with Progress -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Product Information</h3>
                    <p class="text-sm text-gray-500 mt-1">Fill in the details below to create a new product</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm">
                        <i class="fas fa-box mr-2"></i>New Product
                    </span>
                </div>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <div class="flex items-center justify-between max-w-3xl mx-auto">
                <div class="flex items-center flex-1">
                    <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">1</div>
                    <div class="ml-2">
                        <p class="text-sm font-medium text-gray-900">Basic Info</p>
                        <p class="text-xs text-gray-500">Name, category, brand, model</p>
                    </div>
                </div>
                <div class="w-12 h-0.5 bg-gray-300"></div>
                <div class="flex items-center flex-1">
                    <div class="w-8 h-8 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                    <div class="ml-2">
                        <p class="text-sm font-medium text-gray-500">Pricing</p>
                        <p class="text-xs text-gray-400">Price, tax, stock</p>
                    </div>
                </div>
                <div class="w-12 h-0.5 bg-gray-300"></div>
                <div class="flex items-center flex-1">
                    <div class="w-8 h-8 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <div class="ml-2">
                        <p class="text-sm font-medium text-gray-500">Media</p>
                        <p class="text-xs text-gray-400">Images, description</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <!-- Basic Information Section -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                    Basic Information
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Name Selection -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-3">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-box text-gray-400"></i>
                                </div>
                                <select name="product_name_select" 
                                        id="product_name_select"
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 appearance-none">
                                    <option value="">Select a product name</option>
                                    <!-- iPhone Models (from oldest to latest) -->
                                    <optgroup label="iPhone SE Series">
                                        <option value="iPhone SE (1st generation)">iPhone SE (1st generation)</option>
                                        <option value="iPhone SE (2nd generation)">iPhone SE (2nd generation)</option>
                                        <option value="iPhone SE (3rd generation)">iPhone SE (3rd generation)</option>
                                    </optgroup>
                                    <optgroup label="iPhone Classic Series">
                                        <option value="iPhone 2G">iPhone 2G (Original)</option>
                                        <option value="iPhone 3G">iPhone 3G</option>
                                        <option value="iPhone 3GS">iPhone 3GS</option>
                                        <option value="iPhone 4">iPhone 4</option>
                                        <option value="iPhone 4s">iPhone 4s</option>
                                        <option value="iPhone 5">iPhone 5</option>
                                        <option value="iPhone 5c">iPhone 5c</option>
                                        <option value="iPhone 5s">iPhone 5s</option>
                                        <option value="iPhone 6">iPhone 6</option>
                                        <option value="iPhone 6 Plus">iPhone 6 Plus</option>
                                        <option value="iPhone 6s">iPhone 6s</option>
                                        <option value="iPhone 6s Plus">iPhone 6s Plus</option>
                                        <option value="iPhone 7">iPhone 7</option>
                                        <option value="iPhone 7 Plus">iPhone 7 Plus</option>
                                        <option value="iPhone 8">iPhone 8</option>
                                        <option value="iPhone 8 Plus">iPhone 8 Plus</option>
                                    </optgroup>
                                    <optgroup label="iPhone X Series">
                                        <option value="iPhone X">iPhone X (10)</option>
                                        <option value="iPhone XR">iPhone XR</option>
                                        <option value="iPhone XS">iPhone XS</option>
                                        <option value="iPhone XS Max">iPhone XS Max</option>
                                    </optgroup>
                                    <optgroup label="iPhone 11 Series">
                                        <option value="iPhone 11">iPhone 11</option>
                                        <option value="iPhone 11 Pro">iPhone 11 Pro</option>
                                        <option value="iPhone 11 Pro Max">iPhone 11 Pro Max</option>
                                    </optgroup>
                                    <optgroup label="iPhone 12 Series">
                                        <option value="iPhone 12 Mini">iPhone 12 Mini</option>
                                        <option value="iPhone 12">iPhone 12</option>
                                        <option value="iPhone 12 Pro">iPhone 12 Pro</option>
                                        <option value="iPhone 12 Pro Max">iPhone 12 Pro Max</option>
                                    </optgroup>
                                    <optgroup label="iPhone 13 Series">
                                        <option value="iPhone 13 Mini">iPhone 13 Mini</option>
                                        <option value="iPhone 13">iPhone 13</option>
                                        <option value="iPhone 13 Pro">iPhone 13 Pro</option>
                                        <option value="iPhone 13 Pro Max">iPhone 13 Pro Max</option>
                                    </optgroup>
                                    <optgroup label="iPhone 14 Series">
                                        <option value="iPhone 14">iPhone 14</option>
                                        <option value="iPhone 14 Plus">iPhone 14 Plus</option>
                                        <option value="iPhone 14 Pro">iPhone 14 Pro</option>
                                        <option value="iPhone 14 Pro Max">iPhone 14 Pro Max</option>
                                    </optgroup>
                                    <optgroup label="iPhone 15 Series">
                                        <option value="iPhone 15">iPhone 15</option>
                                        <option value="iPhone 15 Plus">iPhone 15 Plus</option>
                                        <option value="iPhone 15 Pro">iPhone 15 Pro</option>
                                        <option value="iPhone 15 Pro Max">iPhone 15 Pro Max</option>
                                    </optgroup>
                                    <optgroup label="iPhone 16 Series">
                                        <option value="iPhone 16">iPhone 16</option>
                                        <option value="iPhone 16 Plus">iPhone 16 Plus</option>
                                        <option value="iPhone 16 Pro">iPhone 16 Pro</option>
                                        <option value="iPhone 16 Pro Max">iPhone 16 Pro Max</option>
                                    </optgroup>
                                    <optgroup label="iPhone 17 Series (Upcoming)">
                                        <option value="iPhone 17">iPhone 17</option>
                                        <option value="iPhone 17 Plus">iPhone 17 Plus</option>
                                        <option value="iPhone 17 Pro">iPhone 17 Pro</option>
                                        <option value="iPhone 17 Pro Max">iPhone 17 Pro Max</option>
                                        <option value="iPhone 17 Ultra">iPhone 17 Ultra</option>
                                    </optgroup>
                                    <optgroup label="iPhone 18 Series (Future)">
                                        <option value="iPhone 18">iPhone 18</option>
                                        <option value="iPhone 18 Plus">iPhone 18 Plus</option>
                                        <option value="iPhone 18 Pro">iPhone 18 Pro</option>
                                        <option value="iPhone 18 Pro Max">iPhone 18 Pro Max</option>
                                        <option value="iPhone 18 Ultra">iPhone 18 Ultra</option>
                                    </optgroup>
                                    <optgroup label="Samsung Galaxy">
                                        <option value="Samsung Galaxy S24 Ultra">Samsung Galaxy S24 Ultra</option>
                                        <option value="Samsung Galaxy S24+">Samsung Galaxy S24+</option>
                                        <option value="Samsung Galaxy S24">Samsung Galaxy S24</option>
                                        <option value="Samsung Galaxy S23 Ultra">Samsung Galaxy S23 Ultra</option>
                                        <option value="Samsung Galaxy S23+">Samsung Galaxy S23+</option>
                                        <option value="Samsung Galaxy S23">Samsung Galaxy S23</option>
                                        <option value="Samsung Galaxy Z Fold 5">Samsung Galaxy Z Fold 5</option>
                                        <option value="Samsung Galaxy Z Flip 5">Samsung Galaxy Z Flip 5</option>
                                    </optgroup>
                                    <optgroup label="Google Pixel">
                                        <option value="Google Pixel 8 Pro">Google Pixel 8 Pro</option>
                                        <option value="Google Pixel 8">Google Pixel 8</option>
                                        <option value="Google Pixel 7 Pro">Google Pixel 7 Pro</option>
                                        <option value="Google Pixel 7">Google Pixel 7</option>
                                    </optgroup>
                                    <optgroup label="OnePlus">
                                        <option value="OnePlus 12">OnePlus 12</option>
                                        <option value="OnePlus 11">OnePlus 11</option>
                                        <option value="OnePlus Open">OnePlus Open</option>
                                    </optgroup>
                                    <optgroup label="Xiaomi">
                                        <option value="Xiaomi 14 Ultra">Xiaomi 14 Ultra</option>
                                        <option value="Xiaomi 14 Pro">Xiaomi 14 Pro</option>
                                        <option value="Xiaomi 14">Xiaomi 14</option>
                                        <option value="Xiaomi 13 Ultra">Xiaomi 13 Ultra</option>
                                    </optgroup>
                                    <optgroup label="Tecno">
                                        <option value="Tecno Phantom V Fold">Tecno Phantom V Fold</option>
                                        <option value="Tecno Phantom V Flip">Tecno Phantom V Flip</option>
                                        <option value="Tecno Camon 20 Premier">Tecno Camon 20 Premier</option>
                                        <option value="Tecno Spark 10 Pro">Tecno Spark 10 Pro</option>
                                    </optgroup>
                                    <optgroup label="Infinix">
                                        <option value="Infinix Zero 30">Infinix Zero 30</option>
                                        <option value="Infinix Note 30">Infinix Note 30</option>
                                        <option value="Infinix Hot 30">Infinix Hot 30</option>
                                    </optgroup>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 mr-3">OR</span>
                            </div>
                            
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-pencil-alt text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       name="name" 
                                       id="custom_product_name"
                                       value="{{ old('name') }}"
                                       class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition @error('name') border-red-500 @enderror"
                                       placeholder="Or enter custom product name">
                            </div>
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <select name="category_id" 
                                    id="category_select"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 appearance-none @error('category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Brand Dropdown -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Brand <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-building text-gray-400"></i>
                            </div>
                            <select name="brand" 
                                    id="brand_select"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 appearance-none @error('brand') border-red-500 @enderror"
                                    required>
                                <option value="">Select a brand</option>
                                <option value="Apple" {{ old('brand') == 'Apple' ? 'selected' : '' }}>Apple</option>
                                <option value="Samsung" {{ old('brand') == 'Samsung' ? 'selected' : '' }}>Samsung</option>
                                <option value="Google" {{ old('brand') == 'Google' ? 'selected' : '' }}>Google</option>
                                <option value="OnePlus" {{ old('brand') == 'OnePlus' ? 'selected' : '' }}>OnePlus</option>
                                <option value="Xiaomi" {{ old('brand') == 'Xiaomi' ? 'selected' : '' }}>Xiaomi</option>
                                <option value="Huawei" {{ old('brand') == 'Huawei' ? 'selected' : '' }}>Huawei</option>
                                <option value="Nokia" {{ old('brand') == 'Nokia' ? 'selected' : '' }}>Nokia</option>
                                <option value="Sony" {{ old('brand') == 'Sony' ? 'selected' : '' }}>Sony</option>
                                <option value="LG" {{ old('brand') == 'LG' ? 'selected' : '' }}>LG</option>
                                <option value="Motorola" {{ old('brand') == 'Motorola' ? 'selected' : '' }}>Motorola</option>
                                <option value="Tecno" {{ old('brand') == 'Tecno' ? 'selected' : '' }}>Tecno</option>
                                <option value="Infinix" {{ old('brand') == 'Infinix' ? 'selected' : '' }}>Infinix</option>
                                <option value="Itel" {{ old('brand') == 'Itel' ? 'selected' : '' }}>Itel</option>
                                <option value="Realme" {{ old('brand') == 'Realme' ? 'selected' : '' }}>Realme</option>
                                <option value="Oppo" {{ old('brand') == 'Oppo' ? 'selected' : '' }}>Oppo</option>
                                <option value="Vivo" {{ old('brand') == 'Vivo' ? 'selected' : '' }}>Vivo</option>
                                <option value="Other" {{ old('brand') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        @error('brand')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Model Dropdown - Dynamic based on brand selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Model <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-3">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-microchip text-gray-400"></i>
                                </div>
                                <select name="model" 
                                        id="model_select"
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 appearance-none @error('model') border-red-500 @enderror">
                                    <option value="">Select a brand first</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 mr-3">OR</span>
                            </div>
                            
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-pencil-alt text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       name="custom_model" 
                                       id="custom_model"
                                       value="{{ old('custom_model') }}"
                                       class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                                       placeholder="Or enter custom model">
                            </div>
                        </div>
                        @error('model')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Other Brand Input (hidden by default, shows when "Other" is selected) -->
                    <div id="other_brand_container" class="hidden col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Enter Brand Name
                        </label>
                        <input type="text" 
                               name="other_brand" 
                               id="other_brand"
                               value="{{ old('other_brand') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                               placeholder="Enter brand name">
                    </div>
                </div>
            </div>

            <!-- Pricing Section -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-dollar-sign text-green-600 mr-2"></i>
                    Pricing & Inventory
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Price (₦) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">₦</span>
                            </div>
                            <input type="number" 
                                   name="price" 
                                   value="{{ old('price') }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition @error('price') border-red-500 @enderror"
                                   placeholder="0.00"
                                   required>
                        </div>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tax -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tax (%)</label>
                        <div class="relative">
                            <input type="number" 
                                   name="tax" 
                                   value="{{ old('tax', 0) }}"
                                   min="0"
                                   max="100"
                                   step="0.1"
                                   class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                                   placeholder="0">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">%</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Leave as 0 if no tax</p>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Quantity <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-cubes text-gray-400"></i>
                            </div>
                            <input type="number" 
                                   name="quantity" 
                                   value="{{ old('quantity', 0) }}"
                                   min="0"
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition @error('quantity') border-red-500 @enderror"
                                   placeholder="0"
                                   required>
                        </div>
                        @error('quantity')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-images text-blue-600 mr-2"></i>
                    Media
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Main Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Main Image <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-500 transition group cursor-pointer"
                             onclick="document.getElementById('main_image').click()">
                            <input type="file" 
                                   id="main_image"
                                   name="main_image" 
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   class="hidden"
                                   onchange="previewMainImage(this)"
                                   required>
                            <div id="main_image_preview" class="hidden mb-4">
                                <img src="" alt="Preview" class="max-h-32 mx-auto rounded-lg">
                            </div>
                            <div id="main_image_placeholder">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 group-hover:text-purple-500 transition mb-3"></i>
                                <p class="text-sm text-gray-600 group-hover:text-purple-600 transition">Click to upload main image</p>
                                <p class="text-xs text-gray-500 mt-2">JPG, JPEG, PNG, WEBP (Max 2MB)</p>
                            </div>
                        </div>
                        @error('main_image')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Gallery Images -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gallery Images</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-500 transition group cursor-pointer"
                             onclick="document.getElementById('gallery_images').click()">
                            <input type="file" 
                                   id="gallery_images"
                                   name="gallery_images[]" 
                                   multiple
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   class="hidden"
                                   onchange="previewGalleryImages(this)">
                            <div id="gallery_preview_container" class="grid grid-cols-3 gap-2 mb-4 hidden"></div>
                            <div id="gallery_placeholder">
                                <i class="fas fa-images text-4xl text-gray-400 group-hover:text-purple-500 transition mb-3"></i>
                                <p class="text-sm text-gray-600 group-hover:text-purple-600 transition">Click to upload gallery images</p>
                                <p class="text-xs text-gray-500 mt-2">You can select multiple images</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Flags -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-flag text-yellow-600 mr-2"></i>
                    Product Flags
                </h4>
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <label class="flex items-center p-4 bg-white rounded-lg border-2 border-gray-200 hover:border-purple-500 cursor-pointer transition group">
                            <input type="checkbox" name="is_hot_deal" value="1" {{ old('is_hot_deal') ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-700 group-hover:text-purple-600">Hot Deal</span>
                                <span class="block text-xs text-gray-500">Mark as hot deal product</span>
                            </span>
                            <i class="fas fa-fire text-orange-500 ml-auto opacity-50 group-hover:opacity-100 transition"></i>
                        </label>

                        <label class="flex items-center p-4 bg-white rounded-lg border-2 border-gray-200 hover:border-purple-500 cursor-pointer transition group">
                            <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival') ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-700 group-hover:text-purple-600">New Arrival</span>
                                <span class="block text-xs text-gray-500">Mark as new arrival</span>
                            </span>
                            <i class="fas fa-clock text-green-500 ml-auto opacity-50 group-hover:opacity-100 transition"></i>
                        </label>

                        <label class="flex items-center p-4 bg-white rounded-lg border-2 border-gray-200 hover:border-purple-500 cursor-pointer transition group">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-700 group-hover:text-purple-600">Featured</span>
                                <span class="block text-xs text-gray-500">Show on homepage</span>
                            </span>
                            <i class="fas fa-star text-yellow-500 ml-auto opacity-50 group-hover:opacity-100 transition"></i>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-align-left text-indigo-600 mr-2"></i>
                    Product Description <span class="text-red-500 ml-1">*</span>
                </h4>
                
                <div class="relative">
                    <textarea name="description" 
                              rows="8"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition @error('description') border-red-500 @enderror"
                              placeholder="Write a detailed description of your product..."
                              required>{{ old('description') }}</textarea>
                    <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                        <span id="charCount">0</span> characters
                    </div>
                </div>
                @error('description')
                    <p class="text-red-500 text-xs mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-3 order-2 sm:order-1 mt-4 sm:mt-0">
                    <button type="submit" 
                            class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 shadow-lg flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Create Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" 
                       class="bg-gray-100 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancel
                    </a>
                </div>
                <div class="text-sm text-gray-500 order-1 sm:order-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Fields marked with <span class="text-red-500">*</span> are required
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Comprehensive model data by brand
const modelsByBrand = {
    'Apple': [
        // iPhone SE Series
        'iPhone SE (1st generation)',
        'iPhone SE (2nd generation)',
        'iPhone SE (3rd generation)',
        
        // iPhone Classic Series
        'iPhone 2G',
        'iPhone 3G',
        'iPhone 3GS',
        'iPhone 4',
        'iPhone 4s',
        'iPhone 5',
        'iPhone 5c',
        'iPhone 5s',
        'iPhone 6',
        'iPhone 6 Plus',
        'iPhone 6s',
        'iPhone 6s Plus',
        'iPhone 7',
        'iPhone 7 Plus',
        'iPhone 8',
        'iPhone 8 Plus',
        
        // iPhone X Series
        'iPhone X',
        'iPhone XR',
        'iPhone XS',
        'iPhone XS Max',
        
        // iPhone 11 Series
        'iPhone 11',
        'iPhone 11 Pro',
        'iPhone 11 Pro Max',
        
        // iPhone 12 Series
        'iPhone 12 Mini',
        'iPhone 12',
        'iPhone 12 Pro',
        'iPhone 12 Pro Max',
        
        // iPhone 13 Series
        'iPhone 13 Mini',
        'iPhone 13',
        'iPhone 13 Pro',
        'iPhone 13 Pro Max',
        
        // iPhone 14 Series
        'iPhone 14',
        'iPhone 14 Plus',
        'iPhone 14 Pro',
        'iPhone 14 Pro Max',
        
        // iPhone 15 Series
        'iPhone 15',
        'iPhone 15 Plus',
        'iPhone 15 Pro',
        'iPhone 15 Pro Max',
        
        // iPhone 16 Series
        'iPhone 16',
        'iPhone 16 Plus',
        'iPhone 16 Pro',
        'iPhone 16 Pro Max',
        
        // iPhone 17 Series (Upcoming)
        'iPhone 17',
        'iPhone 17 Plus',
        'iPhone 17 Pro',
        'iPhone 17 Pro Max',
        'iPhone 17 Ultra',
        
        // iPhone 18 Series (Future)
        'iPhone 18',
        'iPhone 18 Plus',
        'iPhone 18 Pro',
        'iPhone 18 Pro Max',
        'iPhone 18 Ultra',
        
        // iPad Series
        'iPad Pro 12.9-inch (6th gen)',
        'iPad Pro 11-inch (4th gen)',
        'iPad Air (5th gen)',
        'iPad (10th gen)',
        'iPad Mini (6th gen)',
        
        // MacBook Series
        'MacBook Pro 16-inch (2023)',
        'MacBook Pro 14-inch (2023)',
        'MacBook Air 15-inch (2023)',
        'MacBook Air 13-inch (M2)',
        'MacBook Air 13-inch (M1)',
        
        // Apple Watch Series
        'Apple Watch Ultra 2',
        'Apple Watch Series 9',
        'Apple Watch SE (2nd gen)',
        'Apple Watch Series 8',
        'Apple Watch Ultra',
    ],
    'Samsung': [
        // Galaxy S Series
        'Galaxy S24 Ultra', 'Galaxy S24+', 'Galaxy S24',
        'Galaxy S23 Ultra', 'Galaxy S23+', 'Galaxy S23',
        'Galaxy S22 Ultra', 'Galaxy S22+', 'Galaxy S22',
        'Galaxy S21 Ultra', 'Galaxy S21+', 'Galaxy S21',
        'Galaxy S20 Ultra', 'Galaxy S20+', 'Galaxy S20',
        'Galaxy S10', 'Galaxy S10+', 'Galaxy S10e',
        'Galaxy S9', 'Galaxy S9+', 'Galaxy S8', 'Galaxy S8+',
        'Galaxy S7', 'Galaxy S7 Edge', 'Galaxy S6', 'Galaxy S6 Edge',
        
        // Galaxy Note Series
        'Galaxy Note 20 Ultra', 'Galaxy Note 20',
        'Galaxy Note 10+', 'Galaxy Note 10',
        'Galaxy Note 9', 'Galaxy Note 8',
        
        // Galaxy Z Series (Foldable)
        'Galaxy Z Fold 5', 'Galaxy Z Flip 5',
        'Galaxy Z Fold 4', 'Galaxy Z Flip 4',
        'Galaxy Z Fold 3', 'Galaxy Z Flip 3',
        'Galaxy Z Fold 2', 'Galaxy Z Flip',
        
        // Galaxy A Series
        'Galaxy A73', 'Galaxy A72', 'Galaxy A71',
        'Galaxy A54', 'Galaxy A53', 'Galaxy A52',
        'Galaxy A34', 'Galaxy A33', 'Galaxy A32',
        'Galaxy A24', 'Galaxy A23', 'Galaxy A14',
        'Galaxy A13', 'Galaxy A04s', 'Galaxy A03s',
        
        // Galaxy Tab Series
        'Galaxy Tab S9 Ultra', 'Galaxy Tab S9+', 'Galaxy Tab S9',
        'Galaxy Tab S8 Ultra', 'Galaxy Tab S8+', 'Galaxy Tab S8',
        'Galaxy Tab A8', 'Galaxy Tab A7 Lite',
        
        // Galaxy Watch Series
        'Galaxy Watch 6 Classic', 'Galaxy Watch 6',
        'Galaxy Watch 5 Pro', 'Galaxy Watch 5',
        'Galaxy Watch 4 Classic', 'Galaxy Watch 4',
    ],
    'Google': [
        'Pixel 8 Pro', 'Pixel 8', 'Pixel 8a',
        'Pixel 7 Pro', 'Pixel 7', 'Pixel 7a',
        'Pixel 6 Pro', 'Pixel 6', 'Pixel 6a',
        'Pixel 5', 'Pixel 5a',
        'Pixel 4 XL', 'Pixel 4', 'Pixel 4a',
        'Pixel 3 XL', 'Pixel 3', 'Pixel 3a',
        'Pixel Fold', 'Pixel Tablet',
    ],
    'OnePlus': [
        'OnePlus 12', 'OnePlus 12R',
        'OnePlus 11', 'OnePlus 11R',
        'OnePlus 10 Pro', 'OnePlus 10T',
        'OnePlus 9 Pro', 'OnePlus 9', 'OnePlus 9R',
        'OnePlus 8 Pro', 'OnePlus 8T', 'OnePlus 8',
        'OnePlus 7T Pro', 'OnePlus 7T', 'OnePlus 7 Pro', 'OnePlus 7',
        'OnePlus Nord 3', 'OnePlus Nord 2T', 'OnePlus Nord CE 3',
        'OnePlus Nord N30', 'OnePlus Nord N20',
        'OnePlus Open', 'OnePlus Pad',
    ],
    'Xiaomi': [
        'Xiaomi 14 Ultra', 'Xiaomi 14 Pro', 'Xiaomi 14',
        'Xiaomi 13 Ultra', 'Xiaomi 13 Pro', 'Xiaomi 13', 'Xiaomi 13 Lite',
        'Xiaomi 12 Pro', 'Xiaomi 12', 'Xiaomi 12X', 'Xiaomi 12 Lite',
        'Xiaomi 11T Pro', 'Xiaomi 11T', 'Xiaomi 11 Lite',
        'Redmi Note 13 Pro+', 'Redmi Note 13 Pro', 'Redmi Note 13',
        'Redmi Note 12 Pro+', 'Redmi Note 12 Pro', 'Redmi Note 12',
        'Redmi 12', 'Redmi 11', 'Redmi 10',
        'POCO F6', 'POCO F5 Pro', 'POCO F5', 'POCO X6 Pro', 'POCO X6',
        'POCO M6 Pro', 'POCO M5', 'POCO C65', 'POCO C55',
        'Mi Pad 6', 'Mi Pad 5', 'Mi Smart Band 8',
    ],
    'Tecno': [
        'Phantom V Fold', 'Phantom V Flip',
        'Phantom X2 Pro', 'Phantom X2',
        'Camon 20 Premier', 'Camon 20 Pro', 'Camon 20',
        'Camon 19 Pro', 'Camon 19', 'Camon 18',
        'Spark 20 Pro', 'Spark 20', 'Spark 10 Pro', 'Spark 10',
        'Spark 9 Pro', 'Spark 9', 'Spark 8',
        'Pova 5 Pro', 'Pova 5', 'Pova 4 Pro', 'Pova 4',
        'Pop 7', 'Pop 6', 'Pop 5',
    ],
    'Infinix': [
        'Zero 30', 'Zero 20', 'Zero 5G',
        'Note 30 VIP', 'Note 30 Pro', 'Note 30', 'Note 30i',
        'Note 12 VIP', 'Note 12 Pro', 'Note 12', 'Note 11',
        'Hot 40', 'Hot 30', 'Hot 20', 'Hot 11',
        'Smart 8', 'Smart 7', 'Smart 6',
        'GT 20 Pro', 'GT 10 Pro',
    ],
    'Itel': [
        'P55', 'P40', 'P38', 'P36',
        'S23', 'S22', 'S21', 'S18', 'S16',
        'A70', 'A60s', 'A60', 'A58', 'A56', 'A50',
        'Vision 3', 'Vision 2', 'Vision 1',
        'Color Pro 5G', 'Color Pro',
    ],
    'Realme': [
        'GT 5', 'GT 3', 'GT 2 Pro', 'GT 2',
        'Realme 11 Pro+', 'Realme 11 Pro', 'Realme 11',
        'Realme 10 Pro+', 'Realme 10 Pro', 'Realme 10',
        'Realme 9 Pro+', 'Realme 9 Pro', 'Realme 9',
        'Realme 8 Pro', 'Realme 8', 'Realme 7 Pro', 'Realme 7',
        'Realme C67', 'Realme C55', 'Realme C35', 'Realme C25',
        'Realme Narzo 60', 'Realme Narzo 50', 'Realme Narzo 30',
        'Realme Pad 2', 'Realme Pad Mini', 'Realme Pad',
    ],
    'Oppo': [
        'Find N3 Flip', 'Find N3', 'Find N2 Flip', 'Find N2',
        'Find X7 Ultra', 'Find X7', 'Find X6 Pro', 'Find X5 Pro',
        'Reno 11 Pro', 'Reno 11', 'Reno 10 Pro+', 'Reno 10 Pro',
        'Reno 10', 'Reno 9 Pro', 'Reno 9', 'Reno 8 Pro', 'Reno 8',
        'A98', 'A78', 'A58', 'A38', 'A18',
        'Pad 2', 'Pad Air', 'Pad',
    ],
    'Vivo': [
        'X100 Pro+', 'X100 Pro', 'X100',
        'X90 Pro+', 'X90 Pro', 'X90',
        'V30 Pro', 'V30', 'V29 Pro', 'V29',
        'V27 Pro', 'V27', 'V25 Pro', 'V25',
        'Y200', 'Y100', 'Y75', 'Y56', 'Y36',
        'T2 Pro', 'T2', 'T1 Pro', 'T1',
    ],
    'Nokia': [
        'G60', 'G50', 'G42', 'G22', 'G21', 'G11',
        'X30', 'X20', 'X10',
        'C32', 'C31', 'C22', 'C21', 'C12', 'C02',
        'T21', 'T10',
    ],
    'Sony': [
        'Xperia 1 V', 'Xperia 1 IV', 'Xperia 1 III',
        'Xperia 5 V', 'Xperia 5 IV', 'Xperia 5 III',
        'Xperia 10 V', 'Xperia 10 IV', 'Xperia 10 III',
        'Xperia Pro-I',
    ],
    'Motorola': [
        'Edge 50 Pro', 'Edge 40 Pro', 'Edge 40', 'Edge 30 Pro',
        'Moto G Stylus 5G', 'Moto G Power', 'Moto G Play',
        'Moto G 5G', 'Moto G Pure', 'Moto G84', 'Moto G54',
        'Moto E40', 'Moto E30', 'Moto E20', 'Moto E13',
        'Razr 40 Ultra', 'Razr 40', 'Razr 2023', 'Razr 2022',
    ],
    'LG': [
        'Wing', 'Velvet', 'V60 ThinQ', 'V50 ThinQ',
        'G8X ThinQ', 'G8 ThinQ', 'G7 ThinQ',
        'K92', 'K71', 'K62', 'K52', 'K42',
        'Stylo 6', 'Stylo 5', 'Stylo 4',
    ]
};

// Handle product name selection
document.getElementById('product_name_select').addEventListener('change', function() {
    const selectedName = this.value;
    const customNameInput = document.getElementById('custom_product_name');
    
    if (selectedName) {
        customNameInput.value = selectedName;
    }
});

// Handle brand selection change
document.getElementById('brand_select').addEventListener('change', function() {
    const brand = this.value;
    const modelSelect = document.getElementById('model_select');
    const otherBrandContainer = document.getElementById('other_brand_container');
    const customModelInput = document.getElementById('custom_model');
    
    // Clear current options
    modelSelect.innerHTML = '<option value="">Select a model</option>';
    modelSelect.disabled = false;
    
    // Show/hide other brand input
    if (brand === 'Other') {
        otherBrandContainer.classList.remove('hidden');
        modelSelect.disabled = true;
        modelSelect.value = '';
    } else {
        otherBrandContainer.classList.add('hidden');
        
        // Populate models based on selected brand
        if (brand && modelsByBrand[brand]) {
            modelsByBrand[brand].forEach(model => {
                const option = document.createElement('option');
                option.value = model;
                option.textContent = model;
                modelSelect.appendChild(option);
            });
        }
    }
    
    // Clear custom model input
    customModelInput.value = '';
});

// Handle model selection change
document.getElementById('model_select').addEventListener('change', function() {
    const selectedModel = this.value;
    const customModelInput = document.getElementById('custom_model');
    
    if (selectedModel) {
        customModelInput.value = '';
    }
});

// Preselect old values if they exist
document.addEventListener('DOMContentLoaded', function() {
    const oldBrand = '{{ old('brand') }}';
    const oldModel = '{{ old('model') }}';
    const oldProductName = '{{ old('name') }}';
    
    if (oldBrand) {
        const brandSelect = document.getElementById('brand_select');
        brandSelect.value = oldBrand;
        
        // Trigger change event to load models
        const event = new Event('change');
        brandSelect.dispatchEvent(event);
        
        // Set model if exists
        if (oldModel) {
            setTimeout(() => {
                const modelSelect = document.getElementById('model_select');
                modelSelect.value = oldModel;
            }, 100);
        }
    }
    
    // Set product name if it matches any in the dropdown
    if (oldProductName) {
        const productNameSelect = document.getElementById('product_name_select');
        const options = Array.from(productNameSelect.options);
        const matchingOption = options.find(opt => opt.value === oldProductName);
        
        if (matchingOption) {
            productNameSelect.value = oldProductName;
        }
    }
});

// Image preview for main image
function previewMainImage(input) {
    const preview = document.getElementById('main_image_preview');
    const placeholder = document.getElementById('main_image_placeholder');
    const previewImg = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Gallery images preview
function previewGalleryImages(input) {
    const container = document.getElementById('gallery_preview_container');
    const placeholder = document.getElementById('gallery_placeholder');
    
    if (input.files && input.files.length > 0) {
        container.innerHTML = '';
        container.classList.remove('hidden');
        placeholder.classList.add('hidden');
        
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-20 object-cover rounded-lg border-2 border-gray-200">
                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                        <i class="fas fa-eye text-white"></i>
                    </div>
                `;
                container.appendChild(div);
            }
            
            reader.readAsDataURL(file);
        }
    } else {
        container.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }
}

// Character counter for description
document.addEventListener('DOMContentLoaded', function() {
    const description = document.querySelector('textarea[name="description"]');
    const charCount = document.getElementById('charCount');
    
    if (description) {
        charCount.textContent = description.value.length;
        
        description.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value) {
            field.classList.add('border-red-500', 'animate-pulse');
            setTimeout(() => field.classList.remove('animate-pulse'), 1000);
            isValid = false;
        }
    });
    
    // Ensure either model select or custom model is filled
    const modelSelect = document.getElementById('model_select');
    const customModel = document.getElementById('custom_model');
    
    if ((!modelSelect.value || modelSelect.disabled) && !customModel.value) {
        customModel.classList.add('border-red-500', 'animate-pulse');
        setTimeout(() => customModel.classList.remove('animate-pulse'), 1000);
        isValid = false;
        e.preventDefault();
        showNotification('Please select or enter a model', 'error');
    }
    
    // Ensure either product name select or custom name is filled
    const customName = document.getElementById('custom_product_name');
    
    if (!customName.value) {
        customName.classList.add('border-red-500', 'animate-pulse');
        setTimeout(() => customName.classList.remove('animate-pulse'), 1000);
        isValid = false;
        e.preventDefault();
        showNotification('Please enter a product name', 'error');
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});

// Show notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-xl z-50 animate-slideIn ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white`;
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>

<style>
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slideIn {
    animation: slideIn 0.3s ease-out;
}

/* Custom file input styling */
input[type="file"] {
    cursor: pointer;
}

/* Smooth transitions */
input, select, textarea, button {
    transition: all 0.2s ease;
}

/* Focus styles */
input:focus, select:focus, textarea:focus {
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

/* Custom scrollbar for selects */
select {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f1f5f9;
}

select::-webkit-scrollbar {
    width: 8px;
}

select::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

select::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 4px;
}

select::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endpush
@endsection