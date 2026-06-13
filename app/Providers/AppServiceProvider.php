<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Try to get from env, but use hardcoded fallback
        $adminPrefix = env('ADMIN_PREFIX');
        
        // If env not working, use hardcoded value
        if (empty($adminPrefix) || $adminPrefix === 'admin-ebb22fb1a689e3ed') {
            $adminPrefix = 'admin-ebb22fb1a689e3ed'; // Your correct prefix
        }
        
        // Share with all views
        View::share('adminPrefix', $adminPrefix);
        View::share('adminLoginUrl', 'https://dominiongadget.com/' . $adminPrefix . '/login');
    }
}