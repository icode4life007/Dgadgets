@extends('layouts.app')

@section('title', 'Terms of Service - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">Terms of Service</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Terms of Service</h1>
            <p class="text-purple-100 text-lg">Please read these terms carefully before using our services</p>
        </div>

        <div class="p-8 md:p-12 prose prose-lg max-w-none">
            <p class="text-gray-600">Last updated: {{ date('F j, Y') }}</p>

            <h2>Agreement to Terms</h2>
            <p>By accessing or using Dominion Gadgets & Accessories' website and services, you agree to be bound by these Terms of Service. If you disagree with any part of the terms, you may not access our services.</p>

            <h2>Products and Pricing</h2>
            <ul>
                <li>All product descriptions and prices are subject to change without notice</li>
                <li>We reserve the right to modify or discontinue products at any time</li>
                <li>Prices are in Nigerian Naira (₦) and include applicable taxes</li>
                <li>We strive to display accurate product information but cannot guarantee error-free descriptions</li>
            </ul>

            <h2>Orders and Payments</h2>
            <ul>
                <li>Order confirmation does not constitute acceptance of your order</li>
                <li>We reserve the right to cancel orders due to stock unavailability, pricing errors, or suspicious activity</li>
                <li>Payment must be received before order processing begins</li>
                <li>We accept various payment methods as indicated on our website</li>
            </ul>

            <h2>Shipping and Delivery</h2>
            <ul>
                <li>Shipping times are estimates and not guaranteed</li>
                <li>Risk of loss passes to you upon delivery</li>
                <li>You are responsible for providing accurate shipping information</li>
                <li>Additional charges may apply for failed delivery attempts</li>
            </ul>

            <h2>Returns and Refunds</h2>
            <p>Our return and refund policy is outlined in our <a href="{{ route('return-policy') }}" class="text-purple-600 hover:text-purple-700">Return Policy</a> page.</p>

            <h2>User Accounts</h2>
            <ul>
                <li>You are responsible for maintaining account confidentiality</li>
                <li>You must provide accurate and complete information</li>
                <li>We reserve the right to terminate accounts for violations</li>
                <li>Notify us immediately of unauthorized account access</li>
            </ul>

            <h2>Intellectual Property</h2>
            <p>All content on this website, including logos, images, and text, is the property of Dominion Gadget & Accessories and protected by copyright laws.</p>

            <h2>Limitation of Liability</h2>
            <p>Dominion Gadget & Accessories shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of our services.</p>

            <h2>Indemnification</h2>
            <p>You agree to indemnify and hold Dominion Gadget & Accessories harmless from any claims arising from your violation of these terms or your use of our services.</p>

            <h2>Governing Law</h2>
            <p>These terms shall be governed by the laws of the Federal Republic of Nigeria.</p>

            <h2>Changes to Terms</h2>
            <p>We reserve the right to modify these terms at any time. Continued use of our services constitutes acceptance of modified terms.</p>

            <h2>Contact Information</h2>
            <p>For questions about these Terms of Service, contact us at:</p>
            <ul>
                <li>Email: <a href="mailto:{{ setting('legal_email', 'legal@dominiangadget.com') }}" class="text-purple-600">{{ setting('legal_email', 'legal@dominiangadget.com') }}</a></li>
                <li>Phone: <a href="tel:{{ setting('store_phone', '+2348000000000') }}" class="text-purple-600">{{ setting('store_phone', '+234 800 000 0000') }}</a></li>
                <li>Address: {{ setting('store_address', '123 Gadget Street, Lagos, Nigeria') }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection