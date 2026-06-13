@extends('admin.layouts.admin')

@section('title', 'Manage Categories')
@section('page-title', 'Categories')

@section('content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h3 class="text-lg font-semibold">All Categories</h3>
        <a href="{{ route('admin.categories.create') }}" 
           class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition flex items-center w-full sm:w-auto justify-center">
            <i class="fas fa-plus mr-2"></i> Add New Category
        </a>
    </div>

    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Mobile View (Card Layout) -->
        <div class="block md:hidden space-y-4">
            @foreach($categories as $category)
            <div class="border rounded-lg p-4 hover:bg-gray-50">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <!-- Icon -->
                        <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                            @if($category->icon)
                                <i class="{{ $category->icon }} text-xl text-purple-600"></i>
                            @else
                                <i class="fas fa-box text-xl text-gray-400"></i>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-medium">{{ $category->name }}</h4>
                            <p class="text-xs text-gray-500">ID: {{ $category->id }} | Slug: {{ $category->slug }}</p>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    @if($category->is_active)
                        <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full whitespace-nowrap">Active</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded-full whitespace-nowrap">Inactive</span>
                    @endif
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-2 gap-3 mb-3 text-sm">
                    <div>
                        <span class="text-gray-500">Order:</span>
                        <span class="font-medium ml-1">{{ $category->order }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Products:</span>
                        <span class="font-medium ml-1">{{ $category->products_count ?? $category->products->count() }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-2 border-t">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="flex-1 bg-blue-50 text-blue-600 px-3 py-2 rounded-lg text-sm font-medium text-center hover:bg-blue-100 transition">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    
                    <form action="{{ route('admin.categories.destroy', $category) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this category?');"
                          class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-50 text-red-600 px-3 py-2 rounded-lg text-sm font-medium hover:bg-red-100 transition">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop View (Table Layout) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-sm text-gray-500 border-b">
                        <th class="pb-3 pr-4">ID</th>
                        <th class="pb-3 pr-4">Icon</th>
                        <th class="pb-3 pr-4">Name</th>
                        <th class="pb-3 pr-4">Slug</th>
                        <th class="pb-3 pr-4">Order</th>
                        <th class="pb-3 pr-4">Status</th>
                        <th class="pb-3 pr-4">Products</th>
                        <th class="pb-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 pr-4">{{ $category->id }}</td>
                        <td class="py-3 pr-4">
                            @if($category->icon)
                                <i class="{{ $category->icon }} text-xl text-purple-600"></i>
                            @else
                                <i class="fas fa-box text-xl text-gray-400"></i>
                            @endif
                        </td>
                        <td class="py-3 pr-4 font-medium">{{ $category->name }}</td>
                        <td class="py-3 pr-4 text-sm text-gray-500">{{ $category->slug }}</td>
                        <td class="py-3 pr-4">{{ $category->order }}</td>
                        <td class="py-3 pr-4">
                            @if($category->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full whitespace-nowrap">Active</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded-full whitespace-nowrap">Inactive</span>
                            @endif
                        </td>
                        <td class="py-3 pr-4">{{ $category->products_count ?? $category->products->count() }}</td>
                        <td class="py-3">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded-lg transition" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this category?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition" 
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Optional: Add confirmation toast for delete
document.querySelectorAll('form[onsubmit]').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to delete this category?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
@endsection