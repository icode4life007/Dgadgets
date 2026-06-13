<?php

namespace App\Providers;

use App\Helpers\SettingsHelper;
use Illuminate\Support\ServiceProvider;
use View;
use Illuminate\Support\Facades\Schema;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('settings', function () {
            return new SettingsHelper();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Only run if the settings table exists
        if (Schema::hasTable('settings')) {
            try {
                // Share all settings with all views
                $settings = SettingsHelper::all();
                View::share('globalSettings', $settings);
            } catch (\Exception $e) {
                // Log error but don't crash
                \Log::error('Failed to load settings: ' . $e->getMessage());
                View::share('globalSettings', collect());
            }
        }
    }
}