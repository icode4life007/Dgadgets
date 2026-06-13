@extends('layouts.app')

@section('title', 'Payment Methods - Dominion Gadget & Accessories')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900 font-medium">Payment Methods</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Payment Methods</h1>
            <p class="text-purple-100 text-lg">Secure and convenient payment options</p>
        </div>

        <div class="p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <img src="https://cdn.iconscout.com/icon/free/png-256/free-bank-transfer-1767964-1502166.png" alt="Bank Transfer" class="h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Bank Transfer</h3>
                    <p class="text-gray-600 mb-4">Direct bank transfer to our account</p>
                    <div class="text-left bg-white p-4 rounded-lg">
                        <p><span class="font-semibold">Bank:</span> {{ setting('bank_name', 'First Bank of Nigeria') }}</p>
                        <p><span class="font-semibold">Account Name:</span> {{ setting('account_name', 'Dominion Gadget Ltd') }}</p>
                        <p><span class="font-semibold">Account Number:</span> {{ setting('account_number', '1234567890') }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <img src="https://cdn.iconscout.com/icon/free/png-256/free-credit-card-2031755-1713751.png" alt="Card Payment" class="h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Card Payments</h3>
                    <p class="text-gray-600 mb-4">Visa, Mastercard, Verve</p>
                    <div class="flex justify-center space-x-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png" alt="Visa" class="h-8">
                        <img src="https://cdn-icons-png.flaticon.com/512/196/196561.png" alt="Mastercard" class="h-8">
                        <img src="https://cdn.iconscout.com/icon/free/png-256/free-verve-4-698033.png" alt="Verve" class="h-8">
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <img src="https://paystack.com/assets/img/logo.svg" alt="Paystack" class="h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Paystack</h3>
                    <p class="text-gray-600">Secure online payments</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <img src="https://flutterwave.com/images/logo/favicon.png" alt="Flutterwave" class="h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Flutterwave</h3>
                    <p class="text-gray-600">Multiple payment options</p>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-blue-800 mb-3">Payment Security</h3>
                <p class="text-blue-700">All payments are processed securely. We do not store your payment information. Your transactions are protected by industry-standard encryption.</p>
            </div>
        </div>
    </div>
</div>
@endsection