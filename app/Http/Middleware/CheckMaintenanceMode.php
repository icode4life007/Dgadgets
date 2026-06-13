<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Direct database query to get maintenance mode
        try {
            $setting = Setting::where('key', 'maintenance_mode')->first();
            $maintenanceMode = $setting && $setting->value == '1';
        } catch (\Exception $e) {
            $maintenanceMode = false;
        }

        // Check if user is admin
        $isAdmin = Auth::guard('admin')->check();

        // If maintenance mode is ON and user is NOT admin
        if ($maintenanceMode && !$isAdmin) {
            // Allow access to these specific paths
            $allowedPaths = [
                'admin/login',
                'maintenance',
                'login',
                'register',
                'password/reset'
            ];

            foreach ($allowedPaths as $path) {
                if ($request->is($path)) {
                    return $next($request);
                }
            }

            // Return maintenance view for all other routes
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}