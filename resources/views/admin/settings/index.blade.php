@extends('admin.layouts.admin')

@section('title', 'Settings')
@section('page-title', 'System Settings')
@section('page-subtitle', 'Manage your store configuration and preferences')
@section('page-icon', 'fa-cog')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Settings Tabs -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="border-b border-gray-200 overflow-x-auto">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <a href="{{ route('admin.settings.index', ['tab' => 'general']) }}" 
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('tab', 'general') == 'general' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-sliders-h mr-2"></i> General Settings
                </a>
                <a href="{{ route('admin.settings.index', ['tab' => 'profile']) }}" 
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('tab') == 'profile' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-user mr-2"></i> Profile Settings
                </a>
                <a href="{{ route('admin.settings.index', ['tab' => 'password']) }}" 
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('tab') == 'password' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-lock mr-2"></i> Change Password
                </a>
                <a href="{{ route('admin.settings.index', ['tab' => 'store']) }}" 
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('tab') == 'store' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-store mr-2"></i> Store Information
                </a>
             
                <a href="{{ route('admin.settings.index', ['tab' => 'shipping']) }}" 
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('tab') == 'shipping' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-truck mr-2"></i> Shipping Settings
                </a>
            </nav>
        </div>

        <!-- Tab Contents -->
        <div class="p-6">
            @if(request('tab', 'general') == 'general')
                @include('admin.settings.tabs.general')
            @elseif(request('tab') == 'profile')
                @include('admin.settings.tabs.profile')
            @elseif(request('tab') == 'password')
                @include('admin.settings.tabs.password')
            @elseif(request('tab') == 'store')
                @include('admin.settings.tabs.store')
            @elseif(request('tab') == 'payment')
                @include('admin.settings.tabs.payment')
            @elseif(request('tab') == 'shipping')
                @include('admin.settings.tabs.shipping')
            @endif
        </div>
    </div>
</div>
@endsection