@extends('admin.layouts.admin')

@section('title', 'Manage Reviews')
@section('page-title', 'Manage Reviews')

@section('content')
<div class="bg-white rounded-lg shadow">
    <!-- Header with Filters -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h3 class="text-lg font-semibold text-gray-900">All Reviews</h3>
            
            <!-- Filter Tabs -->
            <div class="mt-4 md:mt-0">
                <div class="flex space-x-2">
                    <a href="{{ route('admin.reviews.index', ['filter' => 'all']) }}" 
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ request('filter') == 'all' || !request('filter') ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        All
                    </a>
                    <a href="{{ route('admin.reviews.index', ['filter' => 'pending']) }}" 
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ request('filter') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Pending
                    </a>
                    <a href="{{ route('admin.reviews.index', ['filter' => 'approved']) }}" 
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ request('filter') == 'approved' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Approved
                    </a>
                    <a href="{{ route('admin.reviews.index', ['filter' => 'rejected']) }}" 
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ request('filter') == 'rejected' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Rejected
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="mt-4">
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex gap-2">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by product, customer name, email, or review content..." 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-purple-600">
                </div>
                <button type="submit" 
                        class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.reviews.index') }}" 
                       class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($reviews as $review)
                <tr class="hover:bg-gray-50 transition">
                    <!-- Product -->
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($review->product)
                                <img src="{{ asset($review->product->main_image) }}" 
                                     alt="{{ $review->product->name }}"
                                     class="w-10 h-10 object-cover rounded">
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit($review->product->name, 30) }}</p>
                                    <p class="text-xs text-gray-500">ID: {{ $review->product->id }}</p>
                                </div>
                            @else
                                <div class="ml-3">
                                    <p class="text-sm text-gray-400">Product deleted</p>
                                </div>
                            @endif
                        </div>
                    </td>

                    <!-- Customer -->
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <p class="font-medium text-gray-900">{{ $review->user_name }}</p>
                            <p class="text-xs text-gray-500">{{ $review->email }}</p>
                            @if($review->user_id)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mt-1">
                                    <i class="fas fa-check-circle mr-1 text-xs"></i>Registered
                                </span>
                            @endif
                        </div>
                    </td>

                    <!-- Rating -->
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900 mr-2">{{ $review->rating }}</span>
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-xs"></i>
                                    @else
                                        <i class="far fa-star text-xs"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </td>

                    <!-- Review -->
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 max-w-xs">
                            <p class="truncate">{{ $review->comment }}</p>
                            <button onclick="showFullReview({{ $review->id }})" 
                                    class="text-xs text-purple-600 hover:text-purple-700 mt-1">
                                View full review
                            </button>
                        </div>
                    </td>

                    <!-- Date -->
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <div>{{ $review->created_at->format('M d, Y') }}</div>
                        <div class="text-xs">{{ $review->created_at->format('h:i A') }}</div>
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4">
                        @if($review->is_approved)
                            <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full">
                                Approved
                            </span>
                            @if($review->approved_at)
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $review->approved_at->format('M d, Y') }}
                                </div>
                            @endif
                        @elseif($review->rejected_at)
                            <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded-full">
                                Rejected
                            </span>
                            @if($review->rejected_at)
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $review->rejected_at->format('M d, Y') }}
                                </div>
                            @endif
                        @else
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 text-xs rounded-full">
                                Pending
                            </span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.reviews.show', $review->id) }}" 
                               class="text-blue-600 hover:text-blue-700 p-2 hover:bg-blue-50 rounded-lg transition"
                               title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            @if(!$review->is_approved && !$review->rejected_at)
                                <form action="{{ route('admin.reviews.approve', $review->id) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to approve this review?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-700 p-2 hover:bg-green-50 rounded-lg transition"
                                            title="Approve Review">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.reviews.reject', $review->id) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to reject this review?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded-lg transition"
                                            title="Reject Review">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this review? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded-lg transition"
                                        title="Delete Review">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="text-gray-400 mb-3">
                            <i class="fas fa-star text-5xl"></i>
                        </div>
                        <p class="text-gray-500 text-lg mb-2">No reviews found</p>
                        <p class="text-gray-400 text-sm">
                            @if(request('search'))
                                No reviews match your search criteria.
                            @elseif(request('filter') == 'pending')
                                No pending reviews at the moment.
                            @elseif(request('filter') == 'approved')
                                No approved reviews yet.
                            @elseif(request('filter') == 'rejected')
                                No rejected reviews.
                            @else
                                No reviews have been submitted yet.
                            @endif
                        </p>
                        @if(request('search') || request('filter'))
                            <a href="{{ route('admin.reviews.index') }}" 
                               class="inline-block mt-4 text-purple-600 hover:text-purple-700">
                                <i class="fas fa-arrow-left mr-2"></i>Clear filters
                            </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($reviews->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $reviews->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Review Details Modal -->
<div id="reviewModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeReviewModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                            Full Review
                        </h3>
                        <div id="reviewContent" class="text-gray-700">
                            <!-- Review content will be inserted here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" 
                        onclick="closeReviewModal()" 
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Store reviews data
const reviews = @json($reviews->items());

function showFullReview(reviewId) {
    const review = reviews.find(r => r.id === reviewId);
    if (review) {
        const modal = document.getElementById('reviewModal');
        const content = document.getElementById('reviewContent');
        
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= review.rating) {
                stars += '<i class="fas fa-star text-yellow-400"></i>';
            } else {
                stars += '<i class="far fa-star text-gray-300"></i>';
            }
        }
        
        content.innerHTML = `
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Rating</p>
                    <div class="flex items-center mt-1">
                        <span class="text-lg font-semibold mr-2">${review.rating}</span>
                        <div class="flex text-yellow-400">${stars}</div>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Review</p>
                    <p class="mt-1 text-gray-700 whitespace-pre-wrap">${review.comment}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Customer</p>
                    <p class="mt-1 text-gray-700">${review.user_name}</p>
                    <p class="text-sm text-gray-500">${review.email}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Date</p>
                    <p class="mt-1 text-gray-700">${new Date(review.created_at).toLocaleDateString('en-US', { 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}</p>
                </div>
            </div>
        `;
        
        modal.classList.remove('hidden');
    }
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('reviewModal');
    if (event.target === modal) {
        closeReviewModal();
    }
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeReviewModal();
    }
});
</script>
@endpush
@endsection