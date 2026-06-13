@extends('layouts.app')

@section('title', 'Contact Us - ' . (setting('store_name') ?? 'Dominion Gadget & Accessories'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contact Form -->
        <div class="lg:col-span-2">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Contact Us</h1>
            <p class="text-gray-600 mb-8">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{ route('contact.send') }}" method="POST" class="bg-white rounded-lg shadow-sm p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <input type="text" name="subject" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                           placeholder="How can we help you?">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                    <textarea name="message" rows="5" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                              placeholder="Write your message here..."></textarea>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="submit" 
                            class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                        <i class="fas fa-paper-plane mr-2"></i> Send Message
                    </button>
                    <p class="text-xs text-gray-500">* Required fields</p>
                </div>
            </form>
        </div>
        
        <!-- Contact Information & Quick Links -->
        <div class="lg:col-span-1">
            <div class="bg-gray-100 rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-6">Contact Information</h2>
                
                <div class="space-y-4">
                    <!--<div class="flex items-start">-->
                    <!--    <div class="w-10 h-10 bg-purple-200 rounded-full flex items-center justify-center mr-3 flex-shrink-0">-->
                    <!--        <i class="fas fa-map-marker-alt text-purple-600"></i>-->
                    <!--    </div>-->
                    <!--    <div>-->
                    <!--        <h3 class="font-medium text-gray-900">Address</h3>-->
                    <!--        <p class="text-gray-600 text-sm">{{ setting('store_address') ?? '123 Gadget Street, Lagos, Nigeria' }}</p>-->
                    <!--    </div>-->
                    <!--</div>-->
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-purple-200 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-phone text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Phone</h3>
                            <p class="text-gray-600 text-sm">{{ setting('store_phone') ?? '+234 800 000 0000' }} (Support)</p>
                            <p class="text-gray-600 text-sm">{{ setting('store_phone_alt') ?? '+234 800 000 0001' }} </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-purple-200 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-envelope text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Email</h3>
                            <p class="text-gray-600 text-sm">{{ setting('store_email') ?? 'info@dominiangadget.com' }}</p>
                            <p class="text-gray-600 text-sm">{{ setting('support_email') ?? 'support@dominiangadget.com' }} (Support)</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-purple-200 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-clock text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Business Hours</h3>
                            <p class="text-gray-600 text-sm">{{ setting('working_hours_weekdays') ?? 'Monday - Friday: 9AM - 6PM' }}</p>
                            <p class="text-gray-600 text-sm">{{ setting('working_hours_weekend') ?? 'Saturday: 10AM - 4PM, Sunday: Closed' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Settings/Help Links -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold mb-4">Quick Help</h2>
                
                <div class="space-y-3">
                    <a href="{{ route('faqs') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-purple-50 transition group">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-purple-200">
                            <i class="fas fa-question-circle text-purple-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Frequently Asked Questions</h4>
                            <p class="text-xs text-gray-500">Find answers to common questions</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('shipping-policy') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-purple-50 transition group">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-purple-200">
                            <i class="fas fa-truck text-purple-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Shipping Policy</h4>
                            <p class="text-xs text-gray-500">Learn about our shipping options</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('return-policy') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-purple-50 transition group">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-purple-200">
                            <i class="fas fa-undo-alt text-purple-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Return Policy</h4>
                            <p class="text-xs text-gray-500">7-day money-back guarantee</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('payment-methods') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-purple-50 transition group">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-purple-200">
                            <i class="fas fa-credit-card text-purple-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Payment Methods</h4>
                            <p class="text-xs text-gray-500">Accepted payment options</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('privacy-policy') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-purple-50 transition group">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-purple-200">
                            <i class="fas fa-shield-alt text-purple-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Privacy Policy</h4>
                            <p class="text-xs text-gray-500">How we protect your data</p>
                        </div>
                    </a>
                </div>
                
                <!-- Social Media -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Follow Us</h3>
                    <div class="flex space-x-3">
                        @if(setting('facebook_url'))
                            <a href="{{ setting('facebook_url') }}" class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if(setting('twitter_url'))
                            <a href="{{ setting('twitter_url') }}" class="w-8 h-8 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif
                        @if(setting('instagram_url'))
                            <a href="{{ setting('instagram_url') }}" class="w-8 h-8 bg-pink-600 text-white rounded-full flex items-center justify-center hover:bg-pink-700 transition" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if(setting('whatsapp_number'))
                            <a href="https://wa.me/{{ setting('whatsapp_number') }}" class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection