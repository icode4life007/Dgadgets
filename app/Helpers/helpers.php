<?php

if (!function_exists('setting')) {
    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return app('App\Helpers\SettingsHelper')->get($key, $default);
    }
}

if (!function_exists('settings')) {
    /**
     * Get all settings or a specific setting
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function settings($key = null, $default = null)
    {
        if ($key === null) {
            return app('App\Helpers\SettingsHelper')->all();
        }
        return app('App\Helpers\SettingsHelper')->get($key, $default);
    }
}