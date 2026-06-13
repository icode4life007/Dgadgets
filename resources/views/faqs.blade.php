@extends('layouts.app')

@section('title', 'Frequently Asked Questions - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">FAQs</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Frequently Asked Questions</h1>
            <p class="text-purple-100 text-lg">Find answers to common questions about our products and services</p>
        </div>

        <div class="p-8 md:p-12">
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center" onclick="toggleFaq(1)">
                        <span class="font-semibold text-gray-900">What payment methods do you accept?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" id="faq-icon-1"></i>
                    </button>
                    <div id="faq-answer-1" class="px-6 py-4 hidden">
                        <p class="text-gray-600">We accept various payment methods including:</p>
                        <ul class="list-disc list-inside text-gray-600 mt-2 space-y-1">
                            <li>Bank Transfer</li>
                            <li>Credit/Debit Cards (Visa, Mastercard)</li>
                            
                        </ul>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center" onclick="toggleFaq(2)">
                        <span class="font-semibold text-gray-900">How long does shipping take?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" id="faq-icon-2"></i>
                    </button>
                    <div id="faq-answer-2" class="px-6 py-4 hidden">
                        <p class="text-gray-600">Shipping times vary based on your location:</p>
                        <ul class="list-disc list-inside text-gray-600 mt-2 space-y-1">
                            <li><span class="font-semibold">Lagos:</span> Same day Delivery</li>
                            <li><span class="font-semibold">Other States:</span> 2-5 business days</li>
                            <li><span class="font-semibold">Rural Areas:</span> 5-7 business days</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center" onclick="toggleFaq(3)">
                        <span class="font-semibold text-gray-900">What is your return policy?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" id="faq-icon-3"></i>
                    </button>
                    <div id="faq-answer-3" class="px-6 py-4 hidden">
                        <p class="text-gray-600">We offer a 7-day return policy on most items. Items must be unused and in original packaging. Visit our <a href="{{ route('return-policy') }}" class="text-purple-600 hover:text-purple-700">Return Policy</a> page for more details.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center" onclick="toggleFaq(4)">
                        <span class="font-semibold text-gray-900">Do you offer warranty on products?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" id="faq-icon-4"></i>
                    </button>
                    <div id="faq-answer-4" class="px-6 py-4 hidden">
                        <p class="text-gray-600">Yes, most of our products come with manufacturer warranty. The warranty period varies by product:</p>
                        <ul class="list-disc list-inside text-gray-600 mt-2 space-y-1">
                            <li>Smartphones: 12 months</li>
                            <li>Laptops: 12 months</li>
                            <li>Accessories: 3-6 months</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center" onclick="toggleFaq(5)">
                        <span class="font-semibold text-gray-900">How can I track my order?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" id="faq-icon-5"></i>
                    </button>
                    <div id="faq-answer-5" class="px-6 py-4 hidden">
                        <p class="text-gray-600">Once your order is shipped, you'll receive a tracking number via email and SMS. You can track your order on our website or the courier's website.</p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center" onclick="toggleFaq(6)">
                        <span class="font-semibold text-gray-900">Do you offer bulk purchases?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" id="faq-icon-6"></i>
                    </button>
                    <div id="faq-answer-6" class="px-6 py-4 hidden">
                        <p class="text-gray-600">Yes, we offer special discounts for bulk purchases. Please contact our sales team at <a href="mailto:{{ setting('sales_email', 'sales@dominiangadget.com') }}" class="text-purple-600 hover:text-purple-700">{{ setting('sales_email', 'sales@dominiangadget.com') }}</a> for inquiries.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleFaq(id) {
    const answer = document.getElementById(`faq-answer-${id}`);
    const icon = document.getElementById(`faq-icon-${id}`);
    
    if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        answer.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>
@endpush
@endsection