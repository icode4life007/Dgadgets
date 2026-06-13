@extends('layouts.app')

@section('title', 'Blog - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">Blog</span>
    </nav>

    <!-- Header -->
    <div class="mb-12 text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Dominion Gadget Blog</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Latest news, reviews, and tips about gadgets and technology</p>
    </div>

    <!-- Featured Post -->
    @if(isset($featuredPost))
    <div class="mb-12">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl overflow-hidden shadow-xl">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-8 lg:p-12 text-white">
                    <span class="inline-block px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-semibold mb-4">Featured Post</span>
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4">{{ $featuredPost->title }}</h2>
                    <p class="text-purple-100 mb-6 text-lg">{{ $featuredPost->excerpt }}</p>
                    <div class="flex items-center mb-8">
                        <img src="{{ $featuredPost->author_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($featuredPost->author) }}" 
                             alt="{{ $featuredPost->author }}" 
                             class="w-10 h-10 rounded-full border-2 border-white">
                        <div class="ml-3">
                            <p class="font-semibold">{{ $featuredPost->author }}</p>
                            <p class="text-sm text-purple-200">{{ $featuredPost->created_at->format('M d, Y') }} · {{ $featuredPost->read_time }} min read</p>
                        </div>
                    </div>
                    <a href="{{ route('blog.show', $featuredPost->slug) }}" 
                       class="inline-flex items-center px-6 py-3 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Read More
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <div class="hidden lg:block">
                    <img src="{{ $featuredPost->image ?? 'https://via.placeholder.com/800x600' }}" alt="{{ $featuredPost->title }}" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Blog Categories -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('blog') }}" 
               class="px-4 py-2 {{ !request('category') ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium transition">
                All Posts
            </a>
            <a href="{{ route('blog', ['category' => 'news']) }}" 
               class="px-4 py-2 {{ request('category') == 'news' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium transition">
                News
            </a>
            <a href="{{ route('blog', ['category' => 'reviews']) }}" 
               class="px-4 py-2 {{ request('category') == 'reviews' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium transition">
                Product Reviews
            </a>
            <a href="{{ route('blog', ['category' => 'tips']) }}" 
               class="px-4 py-2 {{ request('category') == 'tips' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium transition">
                Tips & Tricks
            </a>
            <a href="{{ route('blog', ['category' => 'comparisons']) }}" 
               class="px-4 py-2 {{ request('category') == 'comparisons' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium transition">
                Comparisons
            </a>
        </div>
    </div>

    <!-- Blog Posts Grid -->
    @if($posts->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($posts as $post)
        <article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition group">
            <a href="{{ route('blog.show', $post->slug) }}" class="block">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $post->image ?? 'https://via.placeholder.com/400x300' }}" 
                         alt="{{ $post->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    @if($post->category)
                    <span class="absolute top-4 left-4 px-3 py-1 bg-purple-600 text-white text-xs rounded-full">
                        {{ ucfirst($post->category) }}
                    </span>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                        <span class="mx-2">·</span>
                        <span>{{ $post->read_time }} min read</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-purple-600 transition line-clamp-2">
                        {{ $post->title }}
                    </h2>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                    <div class="flex items-center">
                        <img src="{{ $post->author_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author) }}" 
                             alt="{{ $post->author }}" 
                             class="w-8 h-8 rounded-full">
                        <span class="ml-2 text-sm font-medium text-gray-700">{{ $post->author }}</span>
                    </div>
                </div>
            </a>
        </article>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $posts->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
        <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Blog Posts Yet</h3>
        <p class="text-gray-500">Check back soon for the latest gadget news and reviews!</p>
    </div>
    @endif

    <!-- Newsletter Subscription -->
    <div class="mt-16 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-8 text-white">
        <div class="max-w-3xl mx-auto text-center">
            <i class="fas fa-envelope-open-text text-4xl mb-4"></i>
            <h3 class="text-2xl font-bold mb-2">Subscribe to Our Newsletter</h3>
            <p class="text-purple-100 mb-6">Get the latest blog posts and gadget news delivered to your inbox</p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                <input type="email" 
                       placeholder="Enter your email" 
                       class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none">
                <button type="submit" 
                        class="bg-gray-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</div>
@endsection