@extends('admin.layouts.admin')

@section('title', 'Manage Products')
@section('page-title', 'Products')

@section('content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h3 class="text-lg font-semibold">All Products</h3>
        <a href="{{ route('admin.products.create') }}" 
           class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition flex items-center w-full sm:w-auto justify-center">
            <i class="fas fa-plus mr-2"></i> Add New Product
        </a>
    </div>

    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search and Filter - Responsive -->
        <div class="mb-6">
            <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search products..." 
                       class="w-full sm:flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                <select name="category" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                    <option value="">All Categories</option>
                    @foreach($categories ?? App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="w-full sm:w-auto bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i> Search
                </button>
            </form>
        </div>

        <!-- Mobile View (Card Layout) -->
        <div class="block md:hidden space-y-4">
            @forelse($products as $product)
            <div class="border rounded-lg p-4 hover:bg-gray-50">
                <div class="flex items-start space-x-3 mb-3">
                    <!-- Product Image -->
                    <img src="{{ asset($product->main_image) }}" 
                         alt="{{ $product->name }}"
                         class="w-16 h-16 object-cover rounded-lg">
                    
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-medium">{{ $product->name }}</h4>
                                <p class="text-xs text-gray-500">ID: {{ $product->id }}</p>
                            </div>
                            <!-- Status Toggle -->
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       class="sr-only peer toggle-status" 
                                       data-id="{{ $product->id }}"
                                       {{ $product->is_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">{{ $product->brand }} {{ $product->model }}</div>
                        <div class="text-xs text-purple-600 mt-1">{{ $product->category->name }}</div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-2 gap-3 mb-3 text-sm">
                    <div>
                        <span class="text-gray-500">Price:</span>
                        <span class="font-semibold text-purple-600 ml-1">₦{{ number_format($product->price, 0) }}</span>
                        @if($product->tax > 0)
                            <span class="text-xs text-gray-500 block">(+{{ $product->tax }}% tax)</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-gray-500">Quantity:</span>
                        <span class="font-medium ml-1 {{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->quantity }}
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-2 border-t">
                    <a href="{{ route('admin.products.edit', $product) }}" 
                       class="flex-1 bg-blue-50 text-blue-600 px-3 py-2 rounded-lg text-sm font-medium text-center hover:bg-blue-100 transition">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    
                    <form action="{{ route('admin.products.destroy', $product) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this product?');"
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
            @empty
            <div class="text-center py-12 text-gray-500 border rounded-lg">
                <i class="fas fa-box-open text-4xl mb-3"></i>
                <p>No products found</p>
                <a href="{{ route('admin.products.create') }}" class="text-purple-600 hover:text-purple-700 mt-2 inline-block">
                    Add your first product
                </a>
            </div>
            @endforelse
        </div>

        <!-- Desktop View (Table Layout) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-sm text-gray-500 border-b">
                        <th class="pb-3 pr-4">ID</th>
                        <th class="pb-3 pr-4">Image</th>
                        <th class="pb-3 pr-4">Name</th>
                        <th class="pb-3 pr-4">Category</th>
                        <th class="pb-3 pr-4">Price</th>
                        <th class="pb-3 pr-4">Quantity</th>
                        <th class="pb-3 pr-4">Status</th>
                        <th class="pb-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 pr-4">{{ $product->id }}</td>
                        <td class="py-3 pr-4">
                            <img src="{{ asset($product->main_image) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-12 h-12 object-cover rounded">
                        </td>
                        <td class="py-3 pr-4">
                            <div class="font-medium">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500">{{ $product->brand }} {{ $product->model }}</div>
                        </td>
                        <td class="py-3 pr-4">{{ $product->category->name }}</td>
                        <td class="py-3 pr-4">
                            <div>₦{{ number_format($product->price, 0) }}</div>
                            @if($product->tax > 0)
                                <div class="text-xs text-gray-500">+{{ $product->tax }}% tax</div>
                            @endif
                        </td>
                        <td class="py-3 pr-4">
                            <span class="{{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td class="py-3 pr-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       class="sr-only peer toggle-status" 
                                       data-id="{{ $product->id }}"
                                       {{ $product->is_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </td>
                        <td class="py-3">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded-lg transition" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this product?');"
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
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-3"></i>
                            <p>No products found</p>
                            <a href="{{ route('admin.products.create') }}" class="text-purple-600 hover:text-purple-700 mt-2 inline-block">
                                Add your first product
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.toggle-status').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const productId = this.dataset.id;
        const isActive = this.checked;
        
        fetch(`{{ url('admin/products') }}/${productId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                toast.textContent = 'Status updated successfully';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Revert checkbox if error
            this.checked = !this.checked;
        });
    });
});
</script>
@endpush
@endsection