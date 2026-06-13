@extends('layouts.app')

@section('title', 'Privacy Policy - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">Privacy Policy</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Privacy Policy</h1>
            <p class="text-purple-100 text-lg">How we protect and handle your data</p>
        </div>

        <div class="p-8 md:p-12 prose prose-lg max-w-none">
            <p class="text-gray-600">Last updated: {{ date('F j, Y') }}</p>

            <h2>Introduction</h2>
            <p>Dominion Gadget & Accessories ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or make a purchase.</p>

            <h2>Information We Collect</h2>
            <h3>Personal Information</h3>
            <ul>
                <li>Name and contact information (email, phone number, shipping address)</li>
                <li>Payment information (processed securely through our payment partners)</li>
                <li>Account credentials (if you create an account)</li>
                <li>Order history and preferences</li>
            </ul>

            <h3>Automatically Collected Information</h3>
            <ul>
                <li>IP address and browser type</li>
                <li>Device information</li>
                <li>Cookies and usage data</li>
                <li>Referring website addresses</li>
            </ul>

            <h2>How We Use Your Information</h2>
            <ul>
                <li>To process and fulfill your orders</li>
                <li>To communicate with you about your orders and inquiries</li>
                <li>To improve our website and services</li>
                <li>To send promotional offers (with your consent)</li>
                <li>To comply with legal obligations</li>
            </ul>

            <h2>Information Sharing</h2>
            <p>We do not sell, trade, or rent your personal information to third parties. We may share information with:</p>
            <ul>
                <li>Payment processors (to process transactions)</li>
                <li>Shipping partners (to deliver orders)</li>
                <li>Service providers (website hosting, customer support)</li>
                <li>Law enforcement (when required by law)</li>
            </ul>

            <h2>Data Security</h2>
            <p>We implement appropriate technical and organizational measures to protect your personal information. However, no method of transmission over the Internet is 100% secure.</p>

            <h2>Your Rights</h2>
            <p>You have the right to:</p>
            <ul>
                <li>Access your personal information</li>
                <li>Correct inaccurate information</li>
                <li>Request deletion of your information</li>
                <li>Opt-out of marketing communications</li>
            </ul>

            <h2>Cookies</h2>
            <p>We use cookies to enhance your browsing experience. You can control cookies through your browser settings.</p>

            <h2>Changes to This Policy</h2>
            <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page.</p>

            <h2>Contact Us</h2>
            <p>If you have questions about this Privacy Policy, please contact us at:</p>
            <ul>
                <li>Email: <a href="mailto:{{ setting('privacy_email', 'privacy@dominiangadget.com') }}" class="text-purple-600">{{ setting('privacy_email', 'privacy@dominiangadget.com') }}</a></li>
                <li>Phone: <a href="tel:{{ setting('store_phone', '+2348000000000') }}" class="text-purple-600">{{ setting('store_phone', '+234 800 000 0000') }}</a></li>
                <li>Address: {{ setting('store_address', '123 Gadget Street, Lagos, Nigeria') }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection