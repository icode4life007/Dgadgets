<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard') - Dominion Gadget & Accessories</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom Admin Styles -->
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Payment Status Badges */
        .payment-badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border;
        }
        .payment-badge i {
            @apply mr-1;
        }
        .payment-badge.paid {
            @apply bg-green-100 text-green-800 border-green-200;
        }
        .payment-badge.paid i {
            @apply text-green-600;
        }
        .payment-badge.pending {
            @apply bg-yellow-100 text-yellow-800 border-yellow-200;
        }
        .payment-badge.pending i {
            @apply text-yellow-600;
        }
        .payment-badge.failed {
            @apply bg-red-100 text-red-800 border-red-200;
        }
        .payment-badge.failed i {
            @apply text-red-600;
        }
        .payment-badge.refunded {
            @apply bg-gray-100 text-gray-800 border-gray-200;
        }
        .payment-badge.refunded i {
            @apply text-gray-600;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Sidebar transitions */
        .sidebar-transition {
            transition: all 0.3s ease;
        }
        
        /* Mobile menu overlay */
        .menu-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            transition: opacity 0.3s ease;
        }
        
        /* Card hover effects */
        .admin-card {
            transition: all 0.3s ease;
        }
        
        .admin-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Gradient backgrounds */
        .gradient-bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-bg-success {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        }
        
        .gradient-bg-warning {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        }
        
        .gradient-bg-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        /* Table responsive */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .table-responsive table {
                min-width: 600px;
            }
            
            .admin-card {
                margin-bottom: 1rem;
            }
        }
        
        /* Loading animation */
        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-badge.active {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-badge.inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        /* Notification badge pulse animation */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
        }
        
        .notification-pulse {
            animation: pulse 2s infinite;
        }
        
        /* Dropdown animations */
        .dropdown-enter-active, .dropdown-leave-active {
            transition: all 0.2s ease;
        }
        .dropdown-enter-from, .dropdown-leave-to {
            opacity: 0;
            transform: translateY(-10px);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100 antialiased" x-data="{ 
    userMenuOpen: false,
    notificationsOpen: false,
    notificationCount: {{ $pendingOrdersCount ?? 0 }},
    notifications: [
        @if(isset($recentOrders) && $recentOrders->count() > 0)
            @foreach($recentOrders as $order)
            {
                id: {{ $order->id }},
                title: 'New Order #{{ $order->order_number }}',
                message: '{{ $order->customer_name }} placed an order',
                amount: '{{ $order->amount ?? $order->total_amount }}',
                time: '{{ $order->time ?? $order->created_at->diffForHumans() }}',
                read: false
            },
            @endforeach
        @endif
    ]
}">
    <!-- Mobile Menu Toggle Button (visible on mobile only) -->
    <button id="mobileMenuToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-white p-2 rounded-lg shadow-lg">
        <i class="fas fa-bars text-gray-700 text-xl"></i>
    </button>
    
    <!-- Mobile Menu Overlay -->
    <div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden menu-overlay"></div>
    
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 lg:flex w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white z-50 sidebar-transition overflow-y-auto">
            <div class="flex flex-col h-full w-full">
                <!-- Logo Area -->
                <div class="p-6 border-b border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 gradient-bg-primary rounded-xl flex items-center justify-center">
                            <i class="fas fa-bolt text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">Dominion</h1>
                            <p class="text-xs text-gray-400">Admin Panel</p>
                        </div>
                    </div>
                </div>
                
                <!-- Admin Profile Summary (Mobile) -->
                <div class="p-4 border-b border-gray-700 lg:hidden">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::guard('admin')->user()->name }}&background=667eea&color=fff&bold=true" 
                             alt="Profile" 
                             class="w-12 h-12 rounded-full border-2 border-purple-500">
                        <div>
                            <p class="font-semibold">{{ Auth::guard('admin')->user()->name }}</p>
                            <p class="text-xs text-gray-400">{{ Auth::guard('admin')->user()->email }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 mt-6 px-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-chart-pie w-6"></i>
                        <span class="ml-3">Dashboard</span>
                        @if(request()->routeIs('admin.dashboard'))
                            <i class="fas fa-check-circle ml-auto text-xs"></i>
                        @endif
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.products.*') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-box w-6"></i>
                        <span class="ml-3">Products</span>
                        @if(request()->routeIs('admin.products.*'))
                            <i class="fas fa-check-circle ml-auto text-xs"></i>
                        @endif
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.categories.*') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-tags w-6"></i>
                        <span class="ml-3">Categories</span>
                        @if(request()->routeIs('admin.categories.*'))
                            <i class="fas fa-check-circle ml-auto text-xs"></i>
                        @endif
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.orders.*') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-shopping-cart w-6"></i>
                        <span class="ml-3">Orders</span>
                        @if(request()->routeIs('admin.orders.*'))
                            <i class="fas fa-check-circle ml-auto text-xs"></i>
                        @endif
                    </a>
                    
                    <a href="{{ route('admin.reviews.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.reviews.*') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-star w-6"></i>
                        <span class="ml-3">Reviews</span>
                        @if(request()->routeIs('admin.reviews.*'))
                            <i class="fas fa-check-circle ml-auto text-xs"></i>
                        @endif
                    </a>
                    
                    <div class="border-t border-gray-700 my-4"></div>
                    
                    <!-- Settings Link -->
                    <a href="{{ route('admin.settings.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.settings.*') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-cog w-6"></i>
                        <span class="ml-3">Settings</span>
                        @if(request()->routeIs('admin.settings.*'))
                            <i class="fas fa-check-circle ml-auto text-xs"></i>
                        @endif
                    </a>
                </nav>
                
                <!-- Admin Profile (Desktop) -->
                <div class="hidden lg:block p-4 border-t border-gray-700 mt-auto">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::guard('admin')->user()->name }}&background=667eea&color=fff&bold=true" 
                             alt="Profile" 
                             class="w-10 h-10 rounded-full">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ Auth::guard('admin')->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::guard('admin')->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100">
            <!-- Top Bar -->
            <div class="sticky top-0 z-30 bg-white shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between px-4 sm:px-8 py-4">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <!-- Page Title with Icon -->
                        <div class="hidden lg:block w-10 h-10 gradient-bg-primary rounded-lg flex items-center justify-center mr-4">
                            <i class="fas @yield('page-icon', 'fa-chart-line') text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1">@yield('page-subtitle', 'Overview of your store')</p>
                        </div>
                    </div>
                    
                    <!-- Right Side Actions -->
                    <div class="flex items-center justify-between sm:justify-end space-x-2 sm:space-x-4">
                        <!-- Search (hidden on mobile) -->
                        <div class="hidden md:block relative">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" 
                                   placeholder="Search..." 
                                   class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 w-64">
                        </div>
                        
                        <!-- Notifications Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="relative p-2 hover:bg-gray-100 rounded-lg transition">
                                <i class="fas fa-bell text-gray-600 text-lg"></i>
                                <span x-show="notificationCount > 0" 
                                      x-cloak
                                      class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center notification-pulse"
                                      x-text="notificationCount"></span>
                            </button>
                            
                            <!-- Notifications Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="dropdown-enter-active"
                                 x-transition:enter-start="dropdown-enter-from"
                                 x-transition:enter-end="dropdown-enter-to"
                                 x-transition:leave="dropdown-leave-active"
                                 x-transition:leave-start="dropdown-leave-from"
                                 x-transition:leave-end="dropdown-leave-to"
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border z-50">
                                <div class="p-4 border-b">
                                    <h3 class="font-semibold text-gray-800">Notifications</h3>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <template x-for="notification in notifications" :key="notification.id">
                                        <a href="{{ route('admin.orders.index') }}" class="block p-4 hover:bg-gray-50 border-b last:border-b-0 transition">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 gradient-bg-primary rounded-full flex items-center justify-center">
                                                        <i class="fas fa-shopping-cart text-white text-xs"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900" x-text="notification.title"></p>
                                                    <p class="text-xs text-gray-500 mt-1" x-text="notification.message"></p>
                                                    <p class="text-xs text-gray-400 mt-1" x-text="notification.time"></p>
                                                </div>
                                            </div>
                                        </a>
                                    </template>
                                    
                                    <!-- Empty State -->
                                    <div x-show="notifications.length === 0" class="p-8 text-center">
                                        <i class="fas fa-bell-slash text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-sm text-gray-500">No new notifications</p>
                                    </div>
                                </div>
                                <div class="p-3 border-t bg-gray-50 text-center">
                                    <a href="{{ route('admin.orders.index') }}" class="text-xs text-purple-600 hover:text-purple-700">
                                        View all orders
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Menu with Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <!-- User Menu Button -->
                            <button @click="open = !open" 
                                    class="flex items-center space-x-2 hover:bg-gray-100 rounded-lg p-2 transition">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::guard('admin')->user()->name }}&background=667eea&color=fff&bold=true" 
                                     alt="Profile" 
                                     class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-purple-200">
                                <i class="fas fa-chevron-down text-xs text-gray-500 hidden lg:block"></i>
                            </button>
                            
                            <!-- User Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="dropdown-enter-active"
                                 x-transition:enter-start="dropdown-enter-from"
                                 x-transition:enter-end="dropdown-enter-to"
                                 x-transition:leave="dropdown-leave-active"
                                 x-transition:leave-start="dropdown-leave-from"
                                 x-transition:leave-end="dropdown-leave-to"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border z-50">
                                
                                <!-- User Info (Mobile) -->
                                <div class="p-4 border-b lg:hidden">
                                    <p class="font-semibold text-gray-800">{{ Auth::guard('admin')->user()->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ Auth::guard('admin')->user()->email }}</p>
                                </div>
                                
                                <!-- Menu Items -->
                                <div class="py-2">
                                    <a href="{{ route('admin.settings.index', ['tab' => 'profile']) }}" 
                                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-user w-5 text-gray-500"></i>
                                        <span class="ml-3">My Profile</span>
                                    </a>
                                    
                                    <a href="{{ route('admin.settings.index', ['tab' => 'general']) }}" 
                                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-cog w-5 text-gray-500"></i>
                                        <span class="ml-3">General Settings</span>
                                    </a>
                                    
                                    <a href="{{ route('admin.settings.index', ['tab' => 'password']) }}" 
                                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-lock w-5 text-gray-500"></i>
                                        <span class="ml-3">Change Password</span>
                                    </a>
                                    
                                    <a href="{{ route('admin.settings.index', ['tab' => 'store']) }}" 
                                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-store w-5 text-gray-500"></i>
                                        <span class="ml-3">Store Info</span>
                                    </a>
                                    
                                    <a href="{{ route('admin.settings.index', ['tab' => 'shipping']) }}" 
                                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-truck w-5 text-gray-500"></i>
                                        <span class="ml-3">Shipping</span>
                                    </a>
                                    
                                    <hr class="my-2">
                                    
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                                            <i class="fas fa-sign-out-alt w-5"></i>
                                            <span class="ml-3">Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mobile Menu Button (hidden on desktop) -->
                        <button id="mobileUserMenuToggle" class="lg:hidden p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-ellipsis-v text-gray-600"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Search Bar -->
                <div class="md:hidden px-4 pb-4">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" 
                               placeholder="Search..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400">
                    </div>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="p-4 sm:p-6 lg:p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg flex items-center justify-between animate-slideDown">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-500"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg flex items-center justify-between animate-slideDown">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                
                @if(session('warning'))
                    <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-r-lg flex items-center justify-between animate-slideDown">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle mr-3 text-yellow-500"></i>
                            <span>{{ session('warning') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-yellow-700 hover:text-yellow-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                
                <!-- Main Content -->
                @yield('content')
            </div>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-8 mt-auto">
                <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} Dominion Gadget & Accessories. All rights reserved.</p>
                    <div class="flex items-center space-x-4 mt-2 sm:mt-0">
                        <span>v1.0.0</span>
                        <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                        <a href="#" class="hover:text-purple-600 transition">Privacy Policy</a>
                        <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                        <a href="#" class="hover:text-purple-600 transition">Terms of Service</a>
                    </div>
                </div>
            </footer>
        </main>
    </div>
    
    <!-- Loading Spinner (hidden by default) -->
    <div id="loadingSpinner" class="hidden fixed inset-0 bg-white bg-opacity-75 z-50 flex items-center justify-center">
        <div class="loading-spinner"></div>
    </div>
    
    <!-- Mobile Menu JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
            const sidebar = document.getElementById('sidebar');
            
            function toggleMobileMenu() {
                sidebar.classList.toggle('-translate-x-full');
                mobileMenuOverlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }
            
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', toggleMobileMenu);
            }
            
            if (mobileMenuOverlay) {
                mobileMenuOverlay.addEventListener('click', toggleMobileMenu);
            }
            
            // Close sidebar on window resize if open
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) { // lg breakpoint
                    sidebar.classList.remove('-translate-x-full');
                    if (mobileMenuOverlay) {
                        mobileMenuOverlay.classList.add('hidden');
                    }
                    document.body.classList.remove('overflow-hidden');
                }
            });
            
            // Show loading spinner on form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    document.getElementById('loadingSpinner').classList.remove('hidden');
                });
            });
            
            // Auto-hide flash messages after 5 seconds
            const flashMessages = document.querySelectorAll('.bg-green-100, .bg-red-100, .bg-yellow-100');
            flashMessages.forEach(message => {
                setTimeout(() => {
                    message.style.transition = 'opacity 0.5s ease';
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 500);
                }, 5000);
            });
            
            // Real-time notification polling
            function checkNewNotifications() {
                fetch('{{ route("admin.notifications.count") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const currentCount = Alpine.store('notificationCount');
                            if (data.count > currentCount) {
                                // Play sound (optional)
                                // new Audio('/sounds/notification.mp3').play();
                                
                                // Show browser notification if permitted
                                if (Notification.permission === 'granted') {
                                    new Notification('New Order!', {
                                        body: 'You have a new order pending',
                                        icon: '/favicon.ico'
                                    });
                                }
                            }
                            Alpine.store('notificationCount', data.count);
                        }
                    });
            }

            // Request notification permission
            if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
                Notification.requestPermission();
            }

            // Check for new notifications every 30 seconds
            setInterval(checkNewNotifications, 30000);

            // Initial check
            checkNewNotifications();
        });
    </script>
    
    <!-- Additional Styles for Animations -->
    <style>
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }
        
        /* Dropdown animations */
        .dropdown-enter-active, .dropdown-leave-active {
            transition: all 0.2s ease;
        }
        .dropdown-enter-from, .dropdown-leave-to {
            opacity: 0;
            transform: translateY(-10px);
        }
        
        /* Mobile optimizations for tables */
        @media (max-width: 640px) {
            .table-responsive {
                margin: 0 -1rem;
                width: calc(100% + 2rem);
            }
            
            .table-responsive table {
                min-width: 500px;
            }
            
            .card-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
        
        /* Touch-friendly buttons */
        button, a {
            min-height: 44px;
            min-width: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Better spacing for mobile */
        @media (max-width: 768px) {
            .p-8 {
                padding: 1rem;
            }
            
            .space-x-4 > * {
                margin-right: 0.5rem;
            }
        }

        /* Hide elements with x-cloak */
        [x-cloak] { display: none !important; }
    </style>

    @stack('scripts')
</body>
</html>