<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ setting('site_title', 'Dominion Gadget & Accessories') }} - Maintenance Mode</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .maintenance-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-width: 600px;
            width: 100%;
            padding: 40px;
            text-align: center;
        }
        
        .animate-cog {
            animation: spin 4s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .animate-pulse-slow {
            animation: pulse 3s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
</head>
<body>
    <div class="maintenance-card">
        <!-- Logo -->
        <div class="mb-8">
            @if(setting('site_logo'))
                <img src="{{ asset(setting('site_logo')) }}" alt="{{ setting('store_name', 'Dominion Gadget & Accessories') }}" class="h-16 mx-auto">
            @else
                <div class="flex items-center justify-center space-x-3">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-bolt text-white text-3xl"></i>
                    </div>
                    <span class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">Dominion</span>
                </div>
            @endif
        </div>
        
        <!-- Icon -->
        <div class="mb-6">
            <i class="fas fa-cog fa-4x text-purple-600 animate-cog"></i>
            <i class="fas fa-cog fa-3x text-indigo-600 animate-cog ml-2" style="animation-delay: 0.5s;"></i>
        </div>
        
        <!-- Title -->
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Under Maintenance</h1>
        
        <!-- Message -->
        <p class="text-xl text-gray-600 mb-8">
            We're currently performing scheduled maintenance to improve your experience. 
            We'll be back online shortly.
        </p>
        
        <!-- Timer -->
        <div class="bg-purple-50 rounded-lg p-6 mb-8">
            <p class="text-purple-600 mb-2">Estimated completion time:</p>
            <div class="flex justify-center space-x-4">
                <div class="text-center">
                    <span class="text-3xl font-bold text-purple-600" id="hours">00</span>
                    <p class="text-xs text-gray-500">Hours</p>
                </div>
                <span class="text-3xl font-bold text-purple-600">:</span>
                <div class="text-center">
                    <span class="text-3xl font-bold text-purple-600" id="minutes">00</span>
                    <p class="text-xs text-gray-500">Minutes</p>
                </div>
                <span class="text-3xl font-bold text-purple-600">:</span>
                <div class="text-center">
                    <span class="text-3xl font-bold text-purple-600" id="seconds">00</span>
                    <p class="text-xs text-gray-500">Seconds</p>
                </div>
            </div>
        </div>
        
        <!-- Contact -->
        <div class="border-t border-gray-200 pt-8">
            <p class="text-gray-500 mb-4">Need immediate assistance?</p>
            <div class="flex justify-center space-x-4">
                <a href="mailto:{{ setting('support_email', 'support@dominiangadget.com') }}" class="text-purple-600 hover:text-purple-700">
                    <i class="fas fa-envelope mr-2"></i>{{ setting('support_email', 'support@dominiangadget.com') }}
                </a>
                <span class="text-gray-300">|</span>
                <a href="tel:{{ setting('store_phone', '+2348000000000') }}" class="text-purple-600 hover:text-purple-700">
                    <i class="fas fa-phone mr-2"></i>{{ setting('store_phone', '+234 800 000 0000') }}
                </a>
            </div>
        </div>
        
        <!-- Social Links -->
        @if(setting('facebook_url') || setting('twitter_url') || setting('instagram_url'))
        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-gray-500 mb-3">Follow us for updates:</p>
            <div class="flex justify-center space-x-4">
                @if(setting('facebook_url'))
                    <a href="{{ setting('facebook_url') }}" target="_blank" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                @endif
                @if(setting('twitter_url'))
                    <a href="{{ setting('twitter_url') }}" target="_blank" class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                @endif
                @if(setting('instagram_url'))
                    <a href="{{ setting('instagram_url') }}" target="_blank" class="w-10 h-10 bg-pink-600 text-white rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                @endif
            </div>
        </div>
        @endif
    </div>

    <script>
        // Simple countdown timer (example: 2 hours from now)
        function startCountdown(minutes = 120) {
            const endTime = new Date().getTime() + (minutes * 60 * 1000);
            
            const timer = setInterval(function() {
                const now = new Date().getTime();
                const distance = endTime - now;
                
                if (distance < 0) {
                    clearInterval(timer);
                    document.getElementById('hours').textContent = '00';
                    document.getElementById('minutes').textContent = '00';
                    document.getElementById('seconds').textContent = '00';
                    return;
                }
                
                const hours = Math.floor(distance / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                document.getElementById('hours').textContent = String(hours).padStart(2, '0');
                document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
                document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
            }, 1000);
        }
        
        startCountdown(120); // 2 hours
    </script>
</body>
</html>