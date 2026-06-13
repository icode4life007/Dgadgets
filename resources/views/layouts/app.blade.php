<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
<title>@yield('title', setting('site_title', 'Dominion Gadget & Accessories') . ' - Your Premium Gadget & Accessories Store')</title>
<meta name="title" content="@yield('meta_title', setting('site_title', 'Dominion Gadget & Accessories'))">
<meta name="description" content="@yield('meta_description', 'Discover the latest smartphones, laptops, tablets, and accessories at Dominion Gadget. Best prices in Nigeria with fast delivery and 7-day return guarantee. Shop now!')">
<meta name="keywords" content="gadgets, smartphones, laptops, tablets, accessories, Nigeria, tech store, electronics">
<meta name="author" content="Dominion Gadgets & Accessories">
<meta name="robots" content="index, follow">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('og_title', setting('site_title', 'Dominion Gadget & Accessories'))">
<meta property="og:description" content="@yield('og_description', 'Discover premium gadgets and accessories at unbeatable prices. Free delivery in Nigeria, 7-day returns, and 24/7 customer support. Shop the latest tech today!')">
<meta property="og:image" content="@yield('og_image', asset(setting('site_logo', 'uploads/settings/hero-gadget.jpeg')))">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="Dominion Gadgets & Accessories">
<meta property="og:locale" content="en_NG">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="@yield('twitter_title', setting('site_title', 'Dominion Gadget & Accessories'))">
<meta name="twitter:description" content="@yield('twitter_description', 'Your one-stop shop for premium gadgets. Best prices, fast delivery, and secure payments in Nigeria. Shop smartphones, laptops, and accessories today!')">
<meta name="twitter:image" content="@yield('twitter_image', asset(setting('site_logo', 'uploads/settings/hero-gadget.jpeg')))">

<!-- WhatsApp (uses Open Graph) -->
<!-- Instagram (uses Open Graph) -->

<!-- Additional Meta for Better SEO -->
<meta name="geo.region" content="NG">
<meta name="geo.placename" content="Lagos">
<meta name="theme-color" content="#5D3FD3">
<link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    @if (setting('site_favicon'))
        <link rel="icon" type="image/png" href="{{ asset(setting('site_favicon')) }}">
        <link rel="shortcut icon" href="{{ asset(setting('site_favicon')) }}">
        <link rel="apple-touch-icon" href="{{ asset(setting('site_favicon')) }}">
    @else
        <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/724/724954.png">
        <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/724/724954.png">
    @endif


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Custom Styles -->
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%);
        }

        /* Deep Purple - Primary Color */
        .deep-purple {
            color: #5D3FD3;
        }





        .deep-purple-bg {
            background-color: #5D3FD3;
        }

        .deep-purple-border {
            border-color: #5D3FD3;
        }



        .deep-purple-hover:hover {
            background-color: #4A2FA8;
        }

        /* Dark Grey - Secondary Color */
        .dark-grey {
            color: #333333;
        }

        .dark-grey-bg {
            background-color: #333333;
        }

        .dark-grey-border {
            border-color: #333333;
        }

        .dark-grey-hover:hover {
            background-color: #1a1a1a;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #5D3FD3 0%, #4A2FA8 100%);
        }

        .gradient-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: translateY(-5px);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(93, 63, 211, 0.1);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #eaeaea;
        }

        .product-card:hover {
            box-shadow: 0 25px 50px -12px rgba(93, 63, 211, 0.25);
            border-color: #5D3FD3;
        }

        .category-card {
            background: linear-gradient(135deg, #5D3FD3 0%, #4A2FA8 100%);
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 40px -10px rgba(93, 63, 211, 0.4);
        }

        .badge-new {
            background: linear-gradient(135deg, #5D3FD3 0%, #4A2FA8 100%);
        }

        .badge-hot {
            background: linear-gradient(135deg, #333333 0%, #1a1a1a 100%);
        }

        .badge-sale {
            background: linear-gradient(135deg, #5D3FD3 0%, #4A2FA8 100%);
        }

        /* Maintenance mode banner animation */
        .maintenance-banner {
            background: linear-gradient(135deg, #333333 0%, #1a1a1a 100%);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        /* Logo hover effect */
        .logo-hover {
            transition: transform 0.3s ease;
        }

        .logo-hover:hover {
            transform: scale(1.05);
        }

        /* Button Styles */
        .btn-primary {
            background-color: #5D3FD3;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #4A2FA8;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(93, 63, 211, 0.4);
        }

        .btn-secondary {
            background-color: #333333;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #1a1a1a;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(51, 51, 51, 0.4);
        }

        /* Link Styles */
        a.link-purple {
            color: #5D3FD3;
            transition: color 0.3s ease;
        }

        a.link-purple:hover {
            color: #4A2FA8;
            text-decoration: underline;
        }

        /* Focus Styles */
        input:focus,
        select:focus,
        textarea:focus,
        button:focus {
            outline: none;
            ring: 2px solid #5D3FD3;
            ring-opacity: 0.5;
        }

        /* Text Colors */
        .text-primary {
            color: #5D3FD3;
        }

        .text-secondary {
            color: #333333;
        }

        /* Border Colors */
        .border-primary {
            border-color: #5D3FD3;
        }

        .border-secondary {
            border-color: #333333;
        }

        /* Mobile menu transitions */
        .mobile-menu-enter {
            transform: translateX(100%);
        }

        .mobile-menu-enter-active {
            transform: translateX(0);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu-exit {
            transform: translateX(0);
        }

        .mobile-menu-exit-active {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        /* ===== MOBILE-SPECIFIC FIXES FOR HORIZONTAL SCROLL ===== */
        @media (max-width: 768px) {

            /* Fix for the top banner text wrapping */
            .gradient-bg .flex {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.5rem;
            }

            /* Fix for the stats section on mobile */
            .grid-cols-3 {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.5rem;
            }

            /* Fix for hero section text */
            h1.text-4xl {
                font-size: 2rem;
                line-height: 1.2;
            }

            /* Fix for hero section padding */
            .px-4 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            /* Ensure buttons don't overflow */
            .flex-col.space-y-4 {
                width: 100%;
            }

            .flex-col.space-y-4 a {
                width: 100%;
                text-align: center;
            }

            /* Fix for category cards */
            .grid-cols-2 {
                gap: 0.75rem;
            }

            /* Fix for any fixed widths */
            .w-\[448px\],
            .w-\[335px\] {
                max-width: 100% !important;
                width: 100% !important;
            }

            /* Fix for header spacing */
            header .flex.items-center.justify-between {
                flex-wrap: wrap;
                gap: 1rem;
            }

            /* Fix for logo and icons */
            header .flex.items-center.space-x-3 {
                flex-shrink: 0;
            }

            /* Fix for navigation on mobile */
            .overflow-x-auto {
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                padding-bottom: 0.25rem;
            }

            .overflow-x-auto::-webkit-scrollbar {
                display: none;
            }
        }

        /* Basic overflow prevention - less aggressive */
        html,
        body {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body class="antialiased bg-white">

    <!-- Top Banner - Deep Purple Gradient -->
    <div class="gradient-bg text-white py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center text-sm">
                <!-- This checks the database values and displays the banner -->
                <div class="flex items-center space-x-4">
                    @if (setting('free_shipping_enabled'))
                        <span>
                            <i class="fas fa-truck mr-2"></i>
                            Free Shipping on Orders Above
                            ₦{{ number_format(setting('free_shipping_min_amount', 50000), 0) }}
                        </span>
                    @endif
                    <span class="hidden md:inline">
                        <i class="fas fa-clock mr-2"></i>
                        24/7 Customer Support
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    @if (setting('instagram_url'))
                        <a href="{{ setting('instagram_url') }}" class="hover:text-purple-200 transition"
                            target="_blank"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if (setting('whatsapp_number'))
                        <a href="https://wa.me/{{ setting('whatsapp_number') }}"
                            class="hover:text-purple-200 transition" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="glass-effect sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 lg:py-4">
            <!-- Top Row: Logo and Icons -->
           <div class="flex items-center justify-between">
    <!-- Logo - MADE BIGGER ON MOBILE -->
    <a href="{{ route('home') }}" class="flex items-center space-x-2 lg:space-x-3 group flex-shrink-0">
        @if (setting('site_logo'))
            <img src="{{ asset(setting('site_logo')) }}" alt="{{ setting('store_name', 'Dominion') }}"
                class="h-12 sm:h-14 lg:h-16 w-auto logo-hover" style="height: 140px;">
        @else
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 deep-purple-bg rounded-lg lg:rounded-2xl flex items-center justify-center transform group-hover:rotate-6 transition">
                <i class="fas fa-bolt text-white text-2xl sm:text-2xl lg:text-3xl"></i>
            </div>
            <div class="block">
                <span
                    class="text-2xl sm:text-2xl lg:text-3xl font-bold deep-purple bg-clip-text text-transparent bg-gradient-to-r from-[#5D3FD3] to-[#4A2FA8]">
                    {{ setting('store_name', 'Dominion') }}
                </span>
                <span class="text-xl sm:text-xl lg:text-xl font-light dark-grey">Gadget</span>
            </div>
        @endif
    </a>

    <!-- Desktop Search - Hidden on mobile -->
    <div class="hidden lg:block flex-1 max-w-xl mx-8">
        <form action="{{ route('search') }}" method="GET" class="relative">
            <input type="text" name="q" placeholder="Search for gadgets, phones, accessories..."
                class="w-full px-6 py-3 rounded-full border-2 border-gray-200 focus:border-[#5D3FD3] focus:outline-none transition pr-12">
            <button type="submit"
                class="absolute right-3 top-3 text-gray-400 hover:text-[#5D3FD3] transition">
                <i class="fas fa-search text-xl"></i>
            </button>
        </form>
    </div>

    <!-- Header Icons -->
    <div class="flex items-center space-x-2 sm:space-x-4 lg:space-x-6 flex-shrink-0">
        <!-- Track Order Button - Hidden on mobile (moved to menu) -->
        <a href="{{ route('order.track') }}" class="relative group hidden sm:block">
            <div
                class="p-2 sm:p-2.5 lg:p-3 rounded-full bg-gray-100 group-hover:deep-purple-bg group-hover:bg-opacity-10 transition">
                <i class="fas fa-truck text-base sm:text-lg lg:text-xl text-gray-600 group-hover:text-[#5D3FD3] transition"></i>
            </div>
            <span class="absolute -top-1 -right-1 text-[0.6rem] hidden">0</span>
        </a>

        <!-- Wishlist - Visible on mobile and desktop -->
        <a href="{{ route('wishlist') }}" class="relative group block">
            <div
                class="p-2 sm:p-2.5 lg:p-3 rounded-full bg-gray-100 group-hover:deep-purple-bg group-hover:bg-opacity-10 transition">
                <i class="far fa-heart text-base sm:text-lg lg:text-xl text-gray-600 group-hover:text-[#5D3FD3] transition"></i>
            </div>
            <span
                class="wishlist-count absolute -top-1 -right-1 bg-red-500 text-white text-[0.6rem] w-4 h-4 sm:w-4.5 sm:h-4.5 lg:w-5 lg:h-5 rounded-full flex items-center justify-center {{ Session::get('wishlist_count', 0) > 0 ? '' : 'hidden' }}">
                {{ Session::get('wishlist_count', 0) }}
            </span>
        </a>

        <!-- Cart - Visible on mobile and desktop -->
        <a href="{{ route('cart') }}" class="relative group block">
            <div
                class="p-2 sm:p-2.5 lg:p-3 rounded-full bg-gray-100 group-hover:deep-purple-bg group-hover:bg-opacity-10 transition">
                <i class="fas fa-shopping-cart text-base sm:text-lg lg:text-xl text-gray-600 group-hover:text-[#5D3FD3] transition"></i>
            </div>
            <span
                class="cart-count absolute -top-1 -right-1 deep-purple-bg text-white text-[0.6rem] w-4 h-4 sm:w-4.5 sm:h-4.5 lg:w-5 lg:h-5 rounded-full flex items-center justify-center">
                {{ Session::get('cart') ? array_sum(Session::get('cart')) : 0 }}
            </span>
        </a>

        <!-- Mobile Menu Toggle (visible on mobile only) -->
        <div class="lg:hidden">
            <button id="mobileMenuToggle"
                class="p-2 rounded-full deep-purple-bg text-white hover:deep-purple-hover transition flex items-center justify-center">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </div>
    </div>
</div>

            <!-- Mobile Search (visible on mobile) -->
            <div class="mt-3 lg:hidden">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Search products..."
                        class="w-full px-4 py-2 rounded-full border-2 border-gray-200 focus:border-[#5D3FD3] focus:outline-none transition pr-10 text-sm">
                    <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-[#5D3FD3] transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-10 lg:h-12">
                    <div class="flex items-center space-x-4 sm:space-x-6 lg:space-x-8 overflow-x-auto pb-1">
                        <a href="{{ route('home') }}"
                            class="dark-grey hover:text-[#5D3FD3] font-medium whitespace-nowrap transition text-xs sm:text-sm {{ request()->routeIs('home') ? 'text-[#5D3FD3]' : '' }}">
                            Home
                        </a>
                        <a href="{{ route('shop') }}"
                            class="dark-grey hover:text-[#5D3FD3] font-medium whitespace-nowrap transition text-xs sm:text-sm {{ request()->routeIs('shop') ? 'text-[#5D3FD3]' : '' }}">
                            Shop
                        </a>
                        <a href="{{ route('shop', ['filter' => 'new-arrivals']) }}"
                            class="dark-grey hover:text-[#5D3FD3] font-medium whitespace-nowrap transition text-xs sm:text-sm {{ request()->get('filter') == 'new-arrivals' ? 'text-[#5D3FD3]' : '' }}">
                            <span class="flex items-center">
                                New Arrivals
                                <span
                                    class="ml-1 px-1.5 py-0.5 deep-purple-bg text-white text-[0.6rem] rounded-full">New</span>
                            </span>
                        </a>
                        <a href="{{ route('shop', ['filter' => 'hot-deals']) }}"
                            class="dark-grey hover:text-[#5D3FD3] font-medium whitespace-nowrap transition text-xs sm:text-sm {{ request()->get('filter') == 'hot-deals' ? 'text-[#5D3FD3]' : '' }}">
                            <span class="flex items-center">
                                Hot Deals
                                <span
                                    class="ml-1 px-1.5 py-0.5 dark-grey-bg text-white text-[0.6rem] rounded-full"><i class="fas fa-fire"></i></span>
                            </span>
                        </a>
                        <a href="{{ route('brands') }}"
                            class="dark-grey hover:text-[#5D3FD3] font-medium whitespace-nowrap transition text-xs sm:text-sm {{ request()->routeIs('brands') ? 'text-[#5D3FD3]' : '' }}">
                            Brands
                        </a>
                   
                        <!-- Track Order in Navigation - Visible on all screens -->
                        <a href="{{ route('order.track') }}"
                            class="deep-purple text-[#5D3FD3] font-medium whitespace-nowrap transition text-xs sm:text-sm flex items-center bg-purple-50 px-3 py-1 rounded-full hover:bg-purple-100 {{ request()->routeIs('order.track') ? 'bg-purple-200' : '' }}">
                            <i class="fas fa-truck mr-1"></i>
                            Track Order
                        </a>
                    </div>

                    <div class="hidden md:block flex-shrink-0">
                        <a href="tel:{{ setting('store_phone', '+2348000000000') }}"
                            class="text-[#5D3FD3] hover:text-[#4A2FA8] font-medium flex items-center transition text-xs lg:text-sm">
                            <i class="fas fa-phone-alt mr-1 lg:mr-2"></i>
                            <span class="hidden lg:inline">24/7 Support:</span>
                            <span class="text-xs">{{ setting('store_phone', '+234 800 000 0000') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Menu (hidden by default) -->
    <div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

 <div id="mobileMenu"
     class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg z-50 transform transition-transform duration-300 ease-in-out hidden lg:hidden">
    <div class="p-6">
        <div class="flex justify-end mb-6">
            <button id="closeMobileMenu" class="p-2 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <nav class="flex flex-col space-y-4">
            <a href="{{ route('home') }}"
               class="dark-grey hover:text-[#5D3FD3] font-medium py-2 px-4 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('home') ? 'text-[#5D3FD3] bg-purple-50' : '' }}">
                Home
            </a>
            <a href="{{ route('shop') }}"
               class="dark-grey hover:text-[#5D3FD3] font-medium py-2 px-4 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('shop') ? 'text-[#5D3FD3] bg-purple-50' : '' }}">
                Shop
            </a>
            <a href="{{ route('shop', ['filter' => 'new-arrivals']) }}"
               class="dark-grey hover:text-[#5D3FD3] font-medium py-2 px-4 hover:bg-gray-50 rounded-lg transition {{ request()->get('filter') == 'new-arrivals' ? 'text-[#5D3FD3] bg-purple-50' : '' }}">
                <span class="flex items-center justify-between">
                    New Arrivals
                    <span class="px-2 py-0.5 deep-purple-bg text-white text-xs rounded-full">New</span>
                </span>
            </a>
            <a href="{{ route('shop', ['filter' => 'hot-deals']) }}"
               class="dark-grey hover:text-[#5D3FD3] font-medium py-2 px-4 hover:bg-gray-50 rounded-lg transition {{ request()->get('filter') == 'hot-deals' ? 'text-[#5D3FD3] bg-purple-50' : '' }}">
                <span class="flex items-center justify-between">
                    Hot Deals
                    <span class="px-2 py-0.5 dark-grey-bg text-white text-xs rounded-full">🔥</span>
                </span>
            </a>
            
            <!-- Track Order -->
            <a href="{{ route('order.track') }}"
               class="deep-purple text-[#5D3FD3] font-medium py-2 px-4 hover:bg-purple-50 rounded-lg transition flex items-center justify-between {{ request()->routeIs('order.track') ? 'bg-purple-50' : '' }}">
                <span><i class="fas fa-truck mr-2"></i> Track Order</span>
                <span class="deep-purple-bg text-white px-2 py-0.5 rounded-full text-xs">Track</span>
            </a>
            
            <a href="{{ route('brands') }}"
               class="dark-grey hover:text-[#5D3FD3] font-medium py-2 px-4 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('brands') ? 'text-[#5D3FD3] bg-purple-50' : '' }}">
                Brands
            </a>
          
            <a href="{{ route('contact') }}"
               class="dark-grey hover:text-[#5D3FD3] font-medium py-2 px-4 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('contact') ? 'text-[#5D3FD3] bg-purple-50' : '' }}">
                Contact
            </a>
            
            <div class="border-t border-gray-200 my-2"></div>
            
            <!-- Wishlist Link - Fixed -->
            <a href="{{ route('wishlist') }}"
               class="dark-grey hover:text-[#5D3FD3] font-medium py-2 px-4 hover:bg-gray-50 rounded-lg transition flex items-center justify-between">
                <span><i class="far fa-heart mr-2"></i> Wishlist</span>
                <span class="deep-purple-bg text-white px-2 py-0.5 rounded-full text-xs">
                    {{ Session::get('wishlist_count', 0) }}
                </span>
            </a>
            
            <!-- Cart Link -->
            <a href="{{ route('cart') }}"
               class="dark-grey hover:text-[#5D3FD3] font-medium py-2 px-4 hover:bg-gray-50 rounded-lg transition flex items-center justify-between">
                <span><i class="fas fa-shopping-cart mr-2"></i> Cart</span>
                <span class="deep-purple-bg text-white px-2 py-0.5 rounded-full text-xs">
                    {{ Session::get('cart') ? array_sum(Session::get('cart')) : 0 }}
                </span>
            </a>
        </nav>
    </div>
</div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

        <!-- Footer -->
    <footer class="dark-grey-bg text-white mt-16">
        <!-- Newsletter -->
        <div class="gradient-bg py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-6 md:mb-0">
                        <h3 class="text-2xl font-bold mb-2">Subscribe to Our Newsletter</h3>
                        <p class="text-purple-100">Get the latest updates on new products and special offers</p>
                    </div>
                    <form class="flex w-full md:w-auto">
                        <input type="email" placeholder="Enter your email"
                            class="flex-1 md:w-80 px-6 py-3 rounded-l-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#5D3FD3]">
                        <button type="submit"
                            class="deep-purple-bg text-white px-8 py-3 rounded-r-lg font-semibold hover:deep-purple-hover transition">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        @if (setting('site_logo'))
                            <img src="{{ asset(setting('site_logo')) }}"
                                alt="{{ setting('store_name', 'Dominion Gadget & Accessories') }}" class="h-14 w-auto logo-hover"
                                style="height: 130px;margin-bottom: 0px; border-radius: 50px;">
                        @else
                            <div class="w-14 h-14 deep-purple-bg rounded-xl flex items-center justify-center">
                                <i class="fas fa-bolt text-white text-2xl"></i>
                            </div>
                        @endif
                    </div>
                    <p class="text-gray-400 mb-6">
                        {{ setting('site_description', 'Your premium destination for the latest gadgets, phones, and accessories. Quality products at affordable prices.') }}
                    </p>
                    <div class="flex space-x-4">
                        @if (setting('facebook_url'))
                            <a href="{{ setting('facebook_url') }}"
                                class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:deep-purple-bg transition"
                                target="_blank">
                                <i class="fab fa-facebook-f text-gray-400 hover:text-white"></i>
                            </a>
                        @endif
                        @if (setting('instagram_url'))
                            <a href="{{ setting('instagram_url') }}"
                                class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:deep-purple-bg transition"
                                target="_blank">
                                <i class="fab fa-instagram text-gray-400 hover:text-white"></i>
                            </a>
                        @endif
                        @if (setting('whatsapp_number'))
                            <a href="https://wa.me/{{ setting('whatsapp_number') }}"
                                class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:deep-purple-bg transition"
                                target="_blank">
                                <i class="fab fa-whatsapp text-gray-400 hover:text-white"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">About Us</a></li>
                        <li><a href="{{ route('contact') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Contact Us</a></li>
                        <li><a href="{{ route('faqs') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">FAQs</a></li>
                        <li><a href="{{ route('shipping-policy') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Shipping Policy</a></li>
                        <li><a href="{{ route('return-policy') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Return Policy</a></li>
                        <li><a href="{{ route('privacy-policy') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Privacy Policy</a></li>
                        <li><a href="{{ route('terms-of-service') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Terms of Service</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Shop Categories</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('category', 'smartphones') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Smartphones</a></li>
                        <li><a href="{{ route('category', 'laptops') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Laptops</a></li>
                        <li><a href="{{ route('category', 'tablets') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Tablets</a></li>
                        <li><a href="{{ route('category', 'accessories') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Accessories</a></li>
                        <li><a href="{{ route('category', 'smart-watches') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Smart Watches</a></li>
                        <li><a href="{{ route('category', 'audio') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Audio</a></li>
                        <li><a href="{{ route('category', 'gaming') }}"
                                class="text-gray-400 hover:text-[#5D3FD3] transition">Gaming</a></li>
                    </ul>
                </div>

                <!-- Contact Info & Settings -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Get in Touch</h4>
                    <ul class="space-y-4">
                        <!--<li class="flex items-start space-x-3">-->
                        <!--    <i class="fas fa-map-marker-alt text-[#5D3FD3] mt-1"></i>-->
                        <!--    <span-->
                        <!--        class="text-gray-400">{{ setting('store_address', '123 Gadget Street, Lagos, Nigeria') }}</span>-->
                        <!--</li>-->
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-phone text-[#5D3FD3]"></i>
                            <span class="text-gray-400">{{ setting('store_phone', '+234 800 000 0000') }}</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-[#5D3FD3]"></i>
                            <span class="text-gray-400">{{ setting('store_email', 'info@dominiangadget.com') }}</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-headset text-[#5D3FD3]"></i>
                            <span
                                class="text-gray-400">{{ setting('support_email', 'support@dominiangadget.com') }}</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-clock text-[#5D3FD3]"></i>
                            <span
                                class="text-gray-400">{{ setting('working_hours_weekdays', 'Mon - Sat: 9AM - 6PM') }}</span>
                        </li>
                    </ul>

                    <!-- Store Settings Links -->
                    <div class="mt-6 pt-6 border-t border-gray-800">
                        <h5 class="text-sm font-semibold text-gray-300 mb-3">Store Information</h5>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('shipping-policy') }}"
                                class="text-xs text-gray-400 hover:text-[#5D3FD3] transition">
                                <i class="fas fa-truck mr-1"></i> Shipping
                            </a>
                            <a href="{{ route('return-policy') }}"
                                class="text-xs text-gray-400 hover:text-[#5D3FD3] transition">
                                <i class="fas fa-undo mr-1"></i> Returns
                            </a>
                         
                            <a href="{{ route('faqs') }}"
                                class="text-xs text-gray-400 hover:text-[#5D3FD3] transition">
                                <i class="fas fa-question-circle mr-1"></i> FAQs
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar with Secret Admin Button -->
            <div class="border-t border-gray-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row items-center justify-between relative">
                    <!-- Left side - Copyright with Secret Click Zone -->
                    <div class="relative mb-4 md:mb-0">
                        <!-- Secret Click Area - Positioned over copyright text -->
                        <div id="secretAdminZone" 
                             class="absolute inset-0 cursor-pointer z-20" 
                             style="width: 350px; height: 30px; left: 0;">
                        </div>
                        
                        <!-- Normal Copyright Text -->
                        <p class="text-gray-400 text-sm relative z-10">
                            &copy; {{ date('Y') }} {{ setting('store_name', 'Dominion Gadget & Accessories') }}. All rights reserved.
                        </p>
                        
                        <!-- Hidden Admin Popup (appears after 5 clicks) - USING ADMINPREFIX VARIABLE -->
                        <div id="adminSecretPopup" class="hidden absolute bottom-full left-0 mb-3 z-50 min-w-[340px]">
                            <div class="bg-white rounded-xl shadow-2xl border border-purple-200 overflow-hidden">
                                <!-- Header -->
                                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user-secret text-white"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-semibold text-sm">🔐 Hidden Admin Portal</h4>
                                            <p class="text-purple-100 text-xs">Authorized personnel only</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="p-4">
                                    <div class="mb-3">
                                        <p class="text-xs text-gray-500 mb-2">Admin Login URL:</p>
                                        <div class="bg-gray-50 rounded-lg p-2 border border-gray-200">
                                            <code class="text-sm text-purple-600 font-mono break-all">
                                                {{ url($adminPrefix . '/login') }}
                                            </code>
                                        </div>
                                        <p class="text-xs text-green-600 mt-1">
                                            ✅ Your secure admin panel is working!
                                        </p>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex items-center gap-2">
                                        <a href="{{ url($adminPrefix . '/login') }}" 
                                           target="_blank"
                                           class="flex-1 bg-purple-600 text-white text-xs px-3 py-2 rounded-lg hover:bg-purple-700 transition flex items-center justify-center">
                                            <i class="fas fa-external-link-alt mr-1"></i>
                                            Go to Login
                                        </a>
                                        <button onclick="copyAdminUrl('{{ $adminPrefix }}')" 
                                                class="flex-1 border border-purple-600 text-purple-600 text-xs px-3 py-2 rounded-lg hover:bg-purple-50 transition flex items-center justify-center">
                                            <i class="fas fa-copy mr-1"></i>
                                            Copy URL
                                        </button>
                                        <button onclick="closeAdminPopup()" 
                                                class="w-8 h-8 border border-gray-300 text-gray-500 rounded-lg hover:bg-gray-100 transition flex items-center justify-center">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Security Notice -->
                                    <p class="text-[10px] text-gray-400 text-center mt-3">
                                        <i class="fas fa-shield-alt mr-1 text-purple-400"></i>
                                        This URL is confidential. Do not share publicly.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right side - Payment Icons and Links -->
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <div class="flex items-center space-x-4">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png" alt="Visa"
                                class="h-8 opacity-75 hover:opacity-100 transition">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196561.png" alt="Mastercard"
                                class="h-8 opacity-75 hover:opacity-100 transition">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196565.png" alt="Paypal"
                                class="h-8 opacity-75 hover:opacity-100 transition">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196539.png" alt="American Express"
                                class="h-8 opacity-75 hover:opacity-100 transition">
                        </div>
                        <div class="flex items-center space-x-3 text-xs text-gray-500">
                            <a href="{{ route('privacy-policy') }}" class="hover:text-[#5D3FD3] transition">Privacy</a>
                            <span>|</span>
                            <a href="{{ route('terms-of-service') }}" class="hover:text-[#5D3FD3] transition">Terms</a>
                            <span>|</span>
                            <a href="{{ route('sitemap') }}" class="hover:text-[#5D3FD3] transition">Sitemap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    @if (setting('whatsapp_number'))
        <a href="https://wa.me/{{ setting('whatsapp_number') }}?text={{ urlencode(setting('whatsapp_message', 'Hello, I have a question about a product.')) }}"
            target="_blank"
            class="fixed bottom-6 right-6 deep-purple-bg text-white w-16 h-16 rounded-full flex items-center justify-center shadow-2xl hover:deep-purple-hover transition transform hover:scale-110 z-50 animate-float">
            <i class="fab fa-whatsapp text-3xl"></i>
        </a>
    @endif

    <!-- Styles for animations -->
    <style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out;
    }
    </style>

    <!-- Scripts -->
    @stack('scripts')

    <!-- Mobile Menu JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
            const closeMobileMenu = document.getElementById('closeMobileMenu');

            function openMenu() {
                mobileMenu.classList.remove('hidden');
                mobileMenuOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                const icon = mobileMenuToggle.querySelector('i');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            }

            function closeMenu() {
                mobileMenu.classList.add('hidden');
                mobileMenuOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');

                const icon = mobileMenuToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    if (mobileMenu.classList.contains('hidden')) {
                        openMenu();
                    } else {
                        closeMenu();
                    }
                });
            }

            if (closeMobileMenu) {
                closeMobileMenu.addEventListener('click', closeMenu);
            }

            if (mobileMenuOverlay) {
                mobileMenuOverlay.addEventListener('click', closeMenu);
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                    closeMenu();
                }
            });
        });
    </script>
    
    <!-- Secret Admin Button JavaScript -->
    <script>
    // Secret click counter (requires 5 clicks)
    let adminClickCount = 0;
    let clickTimer;

    document.addEventListener('DOMContentLoaded', function() {
        const secretZone = document.getElementById('secretAdminZone');
        
        if (secretZone) {
            secretZone.addEventListener('click', function(e) {
                adminClickCount++;
                
                // Visual feedback (subtle flash)
                this.style.backgroundColor = 'rgba(139, 92, 246, 0.1)';
                setTimeout(() => {
                    this.style.backgroundColor = 'transparent';
                }, 150);
                
                // Reset counter after 3 seconds of inactivity
                clearTimeout(clickTimer);
                clickTimer = setTimeout(() => {
                    adminClickCount = 0;
                }, 3000);
                
                // Show popup after 5 clicks
                if (adminClickCount >= 5) {
                    const popup = document.getElementById('adminSecretPopup');
                    popup.classList.remove('hidden');
                    
                    // Auto-hide after 15 seconds
                    setTimeout(() => {
                        popup.classList.add('hidden');
                    }, 15000);
                    
                    // Success flash
                    this.style.backgroundColor = 'rgba(34, 197, 94, 0.2)';
                    setTimeout(() => {
                        this.style.backgroundColor = 'transparent';
                    }, 500);
                    
                    adminClickCount = 0;
                }
            });
        }
    });

    function closeAdminPopup() {
        document.getElementById('adminSecretPopup').classList.add('hidden');
    }

    function copyAdminUrl(adminPrefix) {
        const url = 'https://dominiongadget.com/' + adminPrefix + '/login';
        navigator.clipboard.writeText(url).then(() => {
            // Show success on copy button
            const btn = event.currentTarget;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
            setTimeout(() => {
                btn.innerHTML = originalText;
            }, 2000);
            
            // Show toast notification
            showToast('Admin URL copied to clipboard!');
        }).catch(() => {
            prompt('Copy this URL manually:', url);
        });
    }

    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-20 right-4 bg-green-600 text-white px-4 py-2 rounded-lg text-sm shadow-lg z-50 animate-fade-in-up';
        toast.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Click outside to close popup
    document.addEventListener('click', function(event) {
        const popup = document.getElementById('adminSecretPopup');
        const zone = document.getElementById('secretAdminZone');
        if (popup && !popup.contains(event.target) && !zone.contains(event.target)) {
            popup.classList.add('hidden');
        }
    });
    </script>
</body>
</html>