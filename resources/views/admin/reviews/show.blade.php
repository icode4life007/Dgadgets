@extends('admin.layouts.admin')

@section('title', 'Review Details')
@section('page-title', 'Review #' . $review->id)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
            <div class="flex justify-between items-center text-white">
                <h3 class="text-lg font-semibold">Review Details</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.reviews.index') }}" 
                       class="px-3 py-1 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Reviews
                    </a>
                </div>
            </div>
        </div>

        <!-- Review Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column - Review Info -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Product Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-3">Product Information</h4>
                        <div class="flex items-center">
                            @if($review->product && $review->product->main_image)
                                <img src="{{ asset($review->product->main_image) }}" 
                                     alt="{{ $review->product->name }}"
                                     class="w-16 h-16 object-cover rounded mr-4">
                            @endif
                            <div>
                                <a href="{{ route('product', $review->product->slug) }}" 
                                   target="_blank"
                                   class="text-lg font-semibold text-purple-600 hover:text-purple-700">
                                    {{ $review->product->name ?? 'Unknown Product' }}
                                </a>
                                <p class="text-sm text-gray-500">Product ID: {{ $review->product_id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Review Form -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-3">Edit Review</h4>
                        <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Rating -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                <div class="flex space-x-1 text-2xl">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star cursor-pointer rating-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                           data-rating="{{ $i }}"
                                           onclick="setRating({{ $i }})"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating" value="{{ $review->rating }}">
                            </div>

                            <!-- Comment -->
                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Review Comment</label>
                                <textarea name="comment" 
                                          id="comment" 
                                          rows="4" 
                                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-purple-600">{{ $review->comment }}</textarea>
                            </div>

                            <!-- Status Selection -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Review Status</label>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="pending" class="form-radio text-yellow-600" 
                                            {{ !$review->is_approved && !$review->rejected_at ? 'checked' : '' }}>
                                        <span class="ml-2">Pending</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="approved" class="form-radio text-green-600" 
                                            {{ $review->is_approved ? 'checked' : '' }}>
                                        <span class="ml-2">Approved</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="rejected" class="form-radio text-red-600" 
                                            {{ $review->rejected_at ? 'checked' : '' }}>
                                        <span class="ml-2">Rejected</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                                Update Review
                            </button>
                        </form>
                    </div>

                    <!-- Review Text Display (if not editing) -->
                    <div class="bg-gray-50 rounded-lg p-4 hidden" id="review-display">
                        <h4 class="text-sm font-medium text-gray-500 mb-3">Review Comment</h4>
                        <p class="text-gray-700 whitespace-pre-line">{{ $review->comment }}</p>
                    </div>

                    <!-- Dates -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Submitted On</p>
                                <p class="text-sm font-medium">{{ $review->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Last Updated</p>
                                <p class="text-sm font-medium">{{ $review->updated_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Reviewer Info & Actions -->
                <div class="space-y-6">
                    <!-- Reviewer Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-3">Reviewer Information</h4>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500">Name</p>
                                <p class="text-sm font-medium">{{ $review->user_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="text-sm font-medium">{{ $review->email }}</p>
                                <a href="mailto:{{ $review->email }}" class="text-xs text-purple-600 hover:text-purple-700 mt-1 inline-block">
                                    <i class="fas fa-envelope mr-1"></i> Send Email
                                </a>
                            </div>
                            @if($review->user_id)
                            <div>
                                <p class="text-xs text-gray-500">User ID</p>
                                <p class="text-sm font-medium">#{{ $review->user_id }}</p>
                                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full mt-1 inline-block">
                                    Registered User
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Status Update -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-3">Quick Status Update</h4>
                        <div class="space-y-2">
                            @if(!$review->is_approved && !$review->rejected_at)
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                                        <i class="fas fa-check-circle mr-2"></i> Approve Review
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center justify-center">
                                        <i class="fas fa-times-circle mr-2"></i> Reject Review
                                    </button>
                                </form>
                            @elseif($review->is_approved)
                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center justify-center">
                                        <i class="fas fa-times-circle mr-2"></i> Move to Rejected
                                    </button>
                                </form>
                            @elseif($review->rejected_at)
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                                        <i class="fas fa-check-circle mr-2"></i> Move to Approved
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition flex items-center justify-center"
                                        onclick="return confirm('Are you sure you want to delete this review? This action cannot be undone.')">
                                    <i class="fas fa-trash mr-2"></i> Delete Review
                                </button>
                            </form>
                            
                            <a href="{{ route('product', $review->product->slug) }}" 
                               target="_blank"
                               class="w-full bg-purple-100 text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-200 transition flex items-center justify-center">
                                <i class="fas fa-external-link-alt mr-2"></i> View on Site
                            </a>
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-3">Status Timeline</h4>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-xs text-gray-600">Created: {{ $review->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            @if($review->approved_at)
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-xs text-gray-600">Approved: {{ $review->approved_at->format('M d, Y H:i') }}</span>
                            </div>
                            @endif
                            @if($review->rejected_at)
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                <span class="text-xs text-gray-600">Rejected: {{ $review->rejected_at->format('M d, Y H:i') }}</span>
                            </div>
                            @endif
                            @if($review->updated_at != $review->created_at)
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                <span class="text-xs text-gray-600">Updated: {{ $review->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Rating star functionality for edit form
function setRating(rating) {
    document.getElementById('rating').value = rating;
    
    // Update star display
    const stars = document.querySelectorAll('.rating-star');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

// Toggle between edit and view mode (optional)
function toggleEdit() {
    document.getElementById('edit-form').classList.toggle('hidden');
    document.getElementById('review-display').classList.toggle('hidden');
}
</script>
@endpush
@endsection