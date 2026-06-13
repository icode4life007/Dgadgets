@extends('layouts.app')

@section('title', $post->title . ' - Dominion Gadget & Accessories Blog')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('blog') }}" class="text-gray-500 hover:text-purple-600">Blog</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">{{ $post->title }}</span>
    </nav>

    <!-- Article -->
    <article class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Featured Image -->
        @if($post->image)
        <div class="h-96 overflow-hidden">
            <img src="{{ $post->image }}" 
                 alt="{{ $post->title }}"
                 class="w-full h-full object-cover">
        </div>
        @endif

        <!-- Article Content -->
        <div class="p-8 md:p-12">
            <!-- Meta Info -->
            <div class="flex items-center flex-wrap gap-4 mb-6">
                <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">
                    {{ ucfirst($post->category) }}
                </span>
                <span class="text-gray-500">
                    <i class="far fa-calendar mr-2"></i>{{ $post->created_at->format('F j, Y') }}
                </span>
                <span class="text-gray-500">
                    <i class="far fa-clock mr-2"></i>{{ $post->read_time }} min read
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">{{ $post->title }}</h1>

            <!-- Author -->
            <div class="flex items-center mb-8 pb-8 border-b border-gray-200">
                <img src="{{ $post->author_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author) }}" 
                     alt="{{ $post->author }}" 
                     class="w-12 h-12 rounded-full">
                <div class="ml-4">
                    <p class="font-semibold text-gray-900">{{ $post->author }}</p>
                    <p class="text-sm text-gray-500">Author</p>
                </div>
            </div>

            <!-- Content -->
            <div class="prose prose-lg max-w-none">
                {!! $post->content !!}
            </div>

            <!-- Tags -->
            @if($post->tags)
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Tags:</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $post->tags) as $tag)
                    <a href="{{ route('blog', ['tag' => trim($tag)]) }}" 
                       class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full hover:bg-gray-200 transition">
                        {{ trim($tag) }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Share -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Share this post:</h3>
                <div class="flex space-x-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                       target="_blank"
                       class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                       target="_blank"
                       class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}" 
                       target="_blank"
                       class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                       target="_blank"
                       class="w-10 h-10 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    @if(isset($relatedPosts) && $relatedPosts->count() > 0)
    <section class="mt-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedPosts as $related)
            <article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                <a href="{{ route('blog.show', $related->slug) }}" class="block">
                    <div class="h-40 overflow-hidden">
                        <img src="{{ $related->image ?? 'https://via.placeholder.com/400x200' }}" 
                             alt="{{ $related->title }}"
                             class="w-full h-full object-cover hover:scale-110 transition duration-300">
                    </div>
                    <div class="p-4">
                        <div class="flex items-center text-xs text-gray-500 mb-2">
                            <span>{{ $related->created_at->format('M d, Y') }}</span>
                            <span class="mx-2">·</span>
                            <span>{{ $related->read_time }} min read</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 hover:text-purple-600 transition line-clamp-2">
                            {{ $related->title }}
                        </h3>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Comments Section -->
    <section class="mt-12 bg-white rounded-xl shadow-sm p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Comments ({{ $post->comments_count ?? 0 }})</h2>
        
        <!-- Comments List -->
        @if(isset($post->comments) && $post->comments->count() > 0)
        <div class="space-y-6 mb-8">
            @foreach($post->comments as $comment)
            <div class="flex space-x-4">
                <img src="{{ $comment->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->name) }}" 
                     alt="{{ $comment->name }}"
                     class="w-10 h-10 rounded-full">
                <div class="flex-1">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900">{{ $comment->name }}</h4>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700">{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
        @endif

        <!-- Comment Form -->
        <form class="mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Leave a Comment</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <input type="text" 
                       placeholder="Your Name *" 
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                <input type="email" 
                       placeholder="Your Email *" 
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
            </div>
            <textarea rows="4" 
                      placeholder="Your Comment *"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 mb-4"></textarea>
            <button type="submit" 
                    class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                Post Comment
            </button>
        </form>
    </section>
</div>
@endsection