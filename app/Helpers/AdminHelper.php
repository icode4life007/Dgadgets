<?php

if (!function_exists('admin_url')) {
    /**
     * Generate a URL to the admin panel
     *
     * @param string $path
     * @return string
     */
    function admin_url($path = '')
    {
        $prefix = env('ADMIN_PREFIX', 'admin');
        return url($prefix . ($path ? '/' . $path : ''));
    }
}

if (!function_exists('admin_route')) {
    /**
     * Generate a named route for admin panel
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    function admin_route($name, $parameters = [])
    {
        return route('admin.' . $name, $parameters);
    }
}