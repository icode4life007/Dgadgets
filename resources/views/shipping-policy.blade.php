@extends('layouts.app')

@section('title', 'Shipping Policy - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">Shipping Policy</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Shipping Policy</h1>
            <p class="text-purple-100 text-lg">Fast and reliable delivery nationwide</p>
        </div>

        <div class="p-8 md:p-12 prose prose-lg max-w-none">
            <h2>Shipping Rates</h2>
            <ul>
                <li><span class="font-semibold">Free Shipping:</span> On orders above ₦50,000</li>
                <li><span class="font-semibold">Standard Shipping:</span> ₦2,500 for orders below ₦50,000</li>
                <li><span class="font-semibold">Express Shipping:</span> ₦5,000 (1-2 business days)</li>
                <li><span class="font-semibold">Local Pickup:</span> Free (available at our Lagos store)</li>
            </ul>

            <h2>Delivery Times</h2>
            <ul>
                <li><span class="font-semibold">Lagos:</span> 1-2 business days</li>
                <li><span class="font-semibold">Other States:</span> 3-5 business days</li>
                <li><span class="font-semibold">Rural Areas:</span> 5-7 business days</li>
            </ul>

            <h2>Order Processing</h2>
            <p>Orders are processed within 24 hours of payment confirmation (Monday-Friday). Orders placed on weekends are processed on Monday.</p>

            <h2>Tracking Your Order</h2>
            <p>Once your order ships, you'll receive a tracking number via email and SMS. You can track your order status in your account dashboard.</p>

            <h2>Shipping Restrictions</h2>
            <p>We currently ship to all states within Nigeria. International shipping is not available at this time.</p>

            <h2>Lost or Damaged Items</h2>
            <p>If your item arrives damaged or is lost in transit, please contact us immediately at <a href="mailto:{{ setting('support_email', 'support@dominiangadget.com') }}" class="text-purple-600">{{ setting('support_email', 'support@dominiangadget.com') }}</a> for assistance.</p>
        </div>
    </div>
</div>
@endsection