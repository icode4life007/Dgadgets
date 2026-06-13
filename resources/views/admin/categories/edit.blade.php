@extends('admin.layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category: ' . $category->name)

@section('content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold">Edit Category Information</h3>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $category->name) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Icon Class</label>
                <input type="text" 
                       name="icon" 
                       value="{{ old('icon', $category->icon) }}"
                       placeholder="fas fa-mobile-alt"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                <p class="text-xs text-gray-500 mt-1">Font Awesome icon class (e.g., fas fa-mobile-alt)</p>
                @if($category->icon)
                    <p class="text-sm text-gray-600 mt-1">Current: <i class="{{ $category->icon }}"></i> {{ $category->icon }}</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                <input type="number" 
                       name="order" 
                       value="{{ old('order', $category->order) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="is_active" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                    <option value="1" {{ old('is_active', $category->is_active) == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $category->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex items-center space-x-3">
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                Update Category
            </button>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection