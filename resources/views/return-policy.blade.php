@extends('layouts.app')

@section('title', 'Return Policy - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">Return Policy</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Return Policy</h1>
            <p class="text-purple-100 text-lg">7-Day Money-Back Guarantee</p>
        </div>

        <div class="p-8 md:p-12">
            <div class="prose prose-lg max-w-none">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Return Policy</h2>
                    <p class="text-gray-600">At Dominion Gadget & Accessories, customer satisfaction is our top priority. If you're not completely satisfied with your purchase, we're here to help.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">7-Day Return Window</h3>
                        <p class="text-gray-600">You have 7 calendar days from the date you received your item to initiate a return.</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-box text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Item Condition</h3>
                        <p class="text-gray-600">Items must be unused, in original packaging, and in the same condition as received.</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-receipt text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Proof of Purchase</h3>
                        <p class="text-gray-600">Please provide your order number, receipt, or proof of purchase when initiating a return.</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Processing Time</h3>
                        <p class="text-gray-600">Returns are processed within 3-5 business days after we receive your item.</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">How to Initiate a Return</h2>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-purple-600 font-semibold">1</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Contact Customer Support</h3>
                                <p class="text-gray-600">Email us at <a href="mailto:{{ setting('support_email', 'support@dominiangadget.com') }}" class="text-purple-600 hover:text-purple-700">{{ setting('support_email', 'support@dominiangadget.com') }}</a> or call <a href="tel:{{ setting('store_phone', '+2348000000000') }}" class="text-purple-600 hover:text-purple-700">{{ setting('store_phone', '+234 800 000 0000') }}</a> to initiate your return.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-purple-600 font-semibold">2</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Provide Order Details</h3>
                                <p class="text-gray-600">Have your order number and reason for return ready. Our team will guide you through the process.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-purple-600 font-semibold">3</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Pack and Ship</h3>
                                <p class="text-gray-600">Securely pack the item in its original packaging and ship it to the address provided by our support team.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-purple-600 font-semibold">4</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Receive Refund or Exchange</h3>
                                <p class="text-gray-600">Once your return is received and inspected, we'll notify you about the approval or rejection of your refund/exchange.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-semibold text-red-800 mb-3">Non-Returnable Items</h3>
                    <p class="text-red-700 mb-3">The following items cannot be returned:</p>
                    <ul class="list-disc list-inside text-red-700 space-y-1">
                        <li>Gift cards</li>
                        <li>Downloadable software products</li>
                        <li>Personal care items (e.g., earphones, smartwatches) due to hygiene reasons</li>
                        <li>Items with visible signs of use or damage caused by the customer</li>
                        <li>Items returned without original packaging</li>
                    </ul>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">Refund Information</h3>
                    <p class="text-blue-700 mb-3">Once your return is approved:</p>
                    <ul class="list-disc list-inside text-blue-700 space-y-1">
                        <li><span class="font-semibold">Credit Card/Mobile Money:</span> Refunds will be processed to your original payment method within 5-7 business days</li>
                        <li><span class="font-semibold">Bank Transfer:</span> Please provide your bank details for transfer</li>
                        <li><span class="font-semibold">Exchange:</span> Replacement items will be shipped within 3-5 business days</li>
                    </ul>
                </div>

                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Need Help?</h3>
                    <p class="text-gray-600 mb-6">Our customer support team is here to assist you with any return-related questions.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                            <i class="fas fa-envelope mr-2"></i> Contact Us
                        </a>
                        <a href="{{ route('faqs') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">
                            <i class="fas fa-question-circle mr-2"></i> Visit FAQs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection