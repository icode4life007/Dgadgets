<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    protected static $settings = null;

    /**
     * Get all settings
     */
    public static function all()
    {
        if (self::$settings === null) {
            try {
                self::$settings = Setting::all()->keyBy('key');
            } catch (\Exception $e) {
                self::$settings = collect([]);
            }
        }
        return self::$settings;
    }

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        try {
            $settings = self::all();
            
            if (!isset($settings[$key])) {
                return $default;
            }
            
            $setting = $settings[$key];
            
            return match($setting->type) {
                'integer' => (int) $setting->value,
                'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
                'json', 'array' => json_decode($setting->value, true),
                default => $setting->value
            };
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Get settings by group
     */
    public static function getGroup($group)
    {
        try {
            return Setting::where('group', $group)
                ->orderBy('sort_order')
                ->get()
                ->keyBy('key');
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Update a setting
     */
    public static function set($key, $value, $type = null)
    {
        try {
            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                if ($type) {
                    $setting->type = $type;
                }
                $setting->value = $value;
                $setting->save();
            }
            
            // Clear cache
            self::$settings = null;
            
            return $setting;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Check if a feature is enabled
     */
    public static function isEnabled($key, $default = false)
    {
        return self::get($key, $default) === true;
    }

    /**
     * Clear the settings cache
     */
    public static function clearCache()
    {
        self::$settings = null;
    }
}

// Global helper function
if (!function_exists('setting')) {
    function setting($key, $default = null) {
        return SettingsHelper::get($key, $default);
    }
}