<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="instagramFeed()" x-init="loadFeed()">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Follow Us on Instagram</h2>
        <a href="https://instagram.com/{{ $instagramUsername ?? '_dominiongadgets' }}" 
           target="_blank"
           class="inline-block text-purple-600 hover:text-purple-700 text-xl font-semibold">
            @{{ $store.instagram?.username ?? '@_dominiongadgets' }}
        </a>
    </div>

    <!-- Profile Stats -->
    <div class="flex justify-center items-center space-x-8 mb-12" x-show="$store.instagram">
        <div class="text-center">
            <div class="text-2xl font-bold text-gray-900" x-text="$store.instagram?.posts_count || '39'"></div>
            <div class="text-sm text-gray-500">Posts</div>
        </div>
        <div class="text-center">
            <div class="text-2xl font-bold text-gray-900" x-text="$store.instagram?.followers_count || '375'"></div>
            <div class="text-sm text-gray-500">Followers</div>
        </div>
        <div class="text-center">
            <div class="text-2xl font-bold text-gray-900" x-text="$store.instagram?.following_count || '23'"></div>
            <div class="text-sm text-gray-500">Following</div>
        </div>
    </div>

    <!-- Bio -->
    <div class="text-center mb-12" x-show="$store.instagram">
        <p class="text-gray-600 text-lg" x-text="$store.instagram?.bio || 'IPHONES SAMSUNG LAPTOPS GADGET PLUG'"></p>
    </div>

    <!-- Instagram Posts Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4" x-show="$store.instagram?.posts?.length > 0">
        <template x-for="post in $store.instagram?.posts" :key="post.id">
            <a :href="'https://instagram.com/p/' + post.id" 
               target="_blank"
               class="relative group overflow-hidden rounded-lg aspect-square">
                <img :src="post.image" 
                     :alt="post.caption"
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                
                <!-- Overlay with caption -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition flex items-end p-4">
                    <p class="text-white text-sm opacity-0 group-hover:opacity-100 transition truncate"
                       x-text="post.caption"></p>
                </div>

                <!-- Price tag (if mentioned in caption) -->
                <div class="absolute top-2 right-2 bg-purple-600 text-white text-xs px-2 py-1 rounded-full opacity-0 group-hover:opacity-100 transition"
                     x-show="post.caption.includes('₦') || post.caption.includes('*')">
                    <span x-text="post.caption.match(/₦[0-9,]+/)?.[0] || post.caption.match(/\*[^*]+\*/)?.[0] || 'New'"></span>
                </div>
            </a>
        </template>
    </div>

    <!-- Loading State -->
    <div class="text-center py-12" x-show="!$store.instagram">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-purple-600 border-t-transparent"></div>
        <p class="mt-4 text-gray-500">Loading Instagram feed...</p>
    </div>

    <!-- Follow Button -->
    <div class="text-center mt-12">
        <a href="https://instagram.com/{{ $instagramUsername ?? '_dominiongadgets' }}" 
           target="_blank"
           class="inline-flex items-center bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-4 rounded-full font-semibold hover:from-purple-700 hover:to-pink-700 transition transform hover:scale-105">
            <i class="fab fa-instagram text-xl mr-3"></i>
            Follow Us on Instagram
        </a>
    </div>
</div>

@push('scripts')
<script>
function instagramFeed() {
    return {
        loadFeed() {
            if (!this.$store.instagram) {
                this.$store.instagram = null;
                
                fetch('/api/instagram-feed')
                    .then(response => response.json())
                    .then(data => {
                        this.$store.instagram = data;
                    })
                    .catch(error => {
                        console.error('Error loading Instagram feed:', error);
                        // Fallback mock data
                        this.$store.instagram = {
                            username: '_dominiongadgets',
                            posts_count: 39,
                            followers_count: 375,
                            following_count: 23,
                            bio: 'IPHONES SAMSUNG LAPTOPS GADGET PLUG',
                            posts: [
                                {
                                    id: 1,
                                    image: 'https://picsum.photos/400/400?random=1',
                                    caption: 'Brand New !! iPhone 16 Pro Max 256GB *N1,800,000 Per ✓*'
                                },
                                {
                                    id: 2,
                                    image: 'https://picsum.photos/400/400?random=2',
                                    caption: 'Samsung Galaxy S24 Ultra 512GB *N1,450,000*'
                                },
                                {
                                    id: 3,
                                    image: 'https://picsum.photos/400/400?random=3',
                                    caption: 'MacBook Pro M3 16GB/1TB *N2,850,000*'
                                },
                                {
                                    id: 4,
                                    image: 'https://picsum.photos/400/400?random=4',
                                    caption: 'AirPods Pro 2nd Gen *N320,000*'
                                },
                                {
                                    id: 5,
                                    image: 'https://picsum.photos/400/400?random=5',
                                    caption: 'iPad Pro M2 12.9" *N1,250,000*'
                                },
                                {
                                    id: 6,
                                    image: 'https://picsum.photos/400/400?random=6',
                                    caption: 'Samsung Galaxy Watch 6 *N280,000*'
                                }
                            ]
                        };
                    });
            }
        }
    }
}
</script>
@endpush