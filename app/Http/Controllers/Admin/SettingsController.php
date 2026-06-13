<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Helpers\SettingsHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        // Get all settings grouped by their keys for easy access in the view
        $settings = Setting::all()->keyBy('key');
        
        return view('admin.settings.index', compact('settings'));
    }

/**
 * Update general settings.
 */
public function updateGeneral(Request $request)
{
    $request->validate([
        'site_title' => 'required|string|max:255',
        'site_description' => 'nullable|string|max:500',
        'admin_email' => 'required|email',
        'timezone' => 'required|string',
        'date_format' => 'required|string',
        'time_format' => 'required|string',
        'maintenance_mode' => 'nullable|in:on,off,1,0,true,false',
        'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,ico,svg,webp|max:1024',
        'delete_logo' => 'nullable|in:1,true,on',
        'delete_favicon' => 'nullable|in:1,true,on',
    ]);

    try {
        // Handle logo deletion
        if ($request->has('delete_logo') && $request->delete_logo) {
            $oldLogo = Setting::where('key', 'site_logo')->first();
            if ($oldLogo && $oldLogo->value && file_exists(public_path($oldLogo->value))) {
                unlink(public_path($oldLogo->value));
            }
            $this->saveSetting('site_logo', '', 'string', 'general');
        }

        // Handle favicon deletion
        if ($request->has('delete_favicon') && $request->delete_favicon) {
            $oldFavicon = Setting::where('key', 'site_favicon')->first();
            if ($oldFavicon && $oldFavicon->value && file_exists(public_path($oldFavicon->value))) {
                unlink(public_path($oldFavicon->value));
            }
            $this->saveSetting('site_favicon', '', 'string', 'general');
        }

        // Handle logo upload (only if not deleted and file exists)
        if ($request->hasFile('site_logo') && !$request->has('delete_logo')) {
            $logo = $request->file('site_logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logoPath = public_path('uploads/settings');
            
            if (!file_exists($logoPath)) {
                mkdir($logoPath, 0777, true);
            }
            
            // Delete old logo if exists (only if we're uploading new one)
            $oldLogo = Setting::where('key', 'site_logo')->first();
            if ($oldLogo && $oldLogo->value && file_exists(public_path($oldLogo->value))) {
                unlink(public_path($oldLogo->value));
            }
            
            $logo->move($logoPath, $logoName);
            $this->saveSetting('site_logo', 'uploads/settings/' . $logoName, 'string', 'general');
        }

        // Handle favicon upload (only if not deleted and file exists)
        if ($request->hasFile('site_favicon') && !$request->has('delete_favicon')) {
            $favicon = $request->file('site_favicon');
            $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
            $faviconPath = public_path('uploads/settings');
            
            if (!file_exists($faviconPath)) {
                mkdir($faviconPath, 0777, true);
            }
            
            // Delete old favicon if exists (only if we're uploading new one)
            $oldFavicon = Setting::where('key', 'site_favicon')->first();
            if ($oldFavicon && $oldFavicon->value && file_exists(public_path($oldFavicon->value))) {
                unlink(public_path($oldFavicon->value));
            }
            
            $favicon->move($faviconPath, $faviconName);
            $this->saveSetting('site_favicon', 'uploads/settings/' . $faviconName, 'string', 'general');
        }

        // Save other settings
        $this->saveSetting('site_title', $request->site_title, 'string', 'general');
        $this->saveSetting('site_description', $request->site_description, 'string', 'general');
        $this->saveSetting('admin_email', $request->admin_email, 'string', 'general');
        $this->saveSetting('timezone', $request->timezone, 'string', 'general');
        $this->saveSetting('date_format', $request->date_format, 'string', 'general');
        $this->saveSetting('time_format', $request->time_format, 'string', 'general');
        $this->saveSetting('maintenance_mode', $request->has('maintenance_mode'), 'boolean', 'general');

        // Clear the settings cache
        if (class_exists('App\Helpers\SettingsHelper')) {
            \App\Helpers\SettingsHelper::clearCache();
        }

        return redirect()->route('admin.settings.index', ['tab' => 'general'])
            ->with('success', 'General settings updated successfully.');

    } catch (\Exception $e) {
        \Log::error('ERROR UPDATING GENERAL SETTINGS: ' . $e->getMessage());
        
        return redirect()->back()
            ->with('error', 'Error updating general settings: ' . $e->getMessage())
            ->withInput();
    }
}

/**
 * Debug version of saveSetting
 */
private function debugSaveSetting($key, $value, $type = 'string', $group = 'general')
{
    \Log::info("--- Saving setting: {$key} ---");
    \Log::info("Original value type: " . gettype($value));
    \Log::info("Original value: " . json_encode($value));
    \Log::info("Type: {$type}");
    \Log::info("Group: {$group}");
    
    // Handle checkbox values
    if ($value === 'on') {
        $value = true;
        \Log::info("Converted 'on' to boolean true");
    } elseif ($value === 'off') {
        $value = false;
        \Log::info("Converted 'off' to boolean false");
    }

    // Convert boolean to string for storage
    if (is_bool($value)) {
        $originalBool = $value;
        $value = $value ? '1' : '0';
        \Log::info("Converted boolean " . ($originalBool ? 'true' : 'false') . " to string: {$value}");
    }

    // Handle null values
    if ($value === null) {
        $value = '';
        \Log::info("Converted null to empty string");
    }

    try {
        // Check if setting exists
        $existing = \App\Models\Setting::where('key', $key)->first();
        if ($existing) {
            \Log::info("Setting exists with ID: {$existing->id}, current value: {$existing->value}");
        } else {
            \Log::info("Setting does not exist, will create new");
        }

        $setting = \App\Models\Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'label' => $this->getLabelForSetting($key),
                'is_public' => $this->isPublicSetting($key)
            ]
        );
        
        \Log::info("Setting saved successfully. ID: {$setting->id}, Key: {$setting->key}, Value: {$setting->value}");
        
    } catch (\Exception $e) {
        \Log::error("Error saving setting {$key}: " . $e->getMessage());
        throw $e;
    }
}

  /**
 * Update profile settings.
 */
public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email,' . Auth::guard('admin')->id(),
        'phone' => 'nullable|string|max:20',
        'job_title' => 'nullable|string|max:100',
        'bio' => 'nullable|string|max:500',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $admin = Auth::guard('admin')->user();
        
        // Handle avatar upload if present
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('uploads/avatars');
            
            if (!file_exists($avatarPath)) {
                mkdir($avatarPath, 0777, true);
            }
            
            // Delete old avatar if exists
            if ($admin->avatar && file_exists(public_path($admin->avatar))) {
                unlink(public_path($admin->avatar));
            }
            
            $avatar->move($avatarPath, $avatarName);
            $admin->avatar = 'uploads/avatars/' . $avatarName;
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->job_title = $request->job_title;
        $admin->bio = $request->bio;
        $admin->save();

        return redirect()->route('admin.settings.index', ['tab' => 'profile'])
            ->with('success', 'Profile updated successfully.');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error updating profile: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        // Check current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withInput();
        }

        // Update password
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return redirect()->route('admin.settings.index', ['tab' => 'password'])
            ->with('success', 'Password changed successfully.');
    }

 /**
 * Update store information.
 */
public function updateStore(Request $request)
{
    $request->validate([
        'store_name' => 'required|string|max:255',
        'store_phone' => 'required|string|max:20',
        'store_phone_alt' => 'nullable|string|max:20',
        'whatsapp_number' => 'nullable|string|max:20', // Add this line
        'store_email' => 'required|email',
        'support_email' => 'nullable|email',
        'store_address' => 'required|string',
        'store_city' => 'required|string',
        'store_state' => 'required|string',
        'store_country' => 'required|string',
        'store_postal' => 'nullable|string|max:20',
        'working_hours_weekdays' => 'nullable|string',
        'working_hours_weekend' => 'nullable|string',
    ]);

    // Save each setting to database
    $this->saveSetting('store_name', $request->store_name, 'string', 'store');
    $this->saveSetting('store_phone', $request->store_phone, 'string', 'store');
    $this->saveSetting('store_phone_alt', $request->store_phone_alt, 'string', 'store');
    $this->saveSetting('whatsapp_number', $request->whatsapp_number, 'string', 'store'); // Add this line
    $this->saveSetting('store_email', $request->store_email, 'string', 'store');
    $this->saveSetting('support_email', $request->support_email, 'string', 'store');
    $this->saveSetting('store_address', $request->store_address, 'text', 'store');
    $this->saveSetting('store_city', $request->store_city, 'string', 'store');
    $this->saveSetting('store_state', $request->store_state, 'string', 'store');
    $this->saveSetting('store_country', $request->store_country, 'string', 'store');
    $this->saveSetting('store_postal', $request->store_postal, 'string', 'store');
    $this->saveSetting('working_hours_weekdays', $request->working_hours_weekdays, 'string', 'store');
    $this->saveSetting('working_hours_weekend', $request->working_hours_weekend, 'string', 'store');

    // Clear the settings cache
    SettingsHelper::clearCache();

    return redirect()->route('admin.settings.index', ['tab' => 'store'])
        ->with('success', 'Store information updated successfully.');
}

    /**
     * Update payment settings.
     */
    public function updatePayment(Request $request)
    {
        $request->validate([
            'currency' => 'required|string',
            'currency_symbol' => 'required|string|max:5',
            'currency_position' => 'required|string|in:left,right,left_space,right_space',
            'paystack_enabled' => 'nullable|boolean',
            'paystack_public_key' => 'nullable|string',
            'paystack_secret_key' => 'nullable|string',
            'flutterwave_enabled' => 'nullable|boolean',
            'flutterwave_public_key' => 'nullable|string',
            'flutterwave_secret_key' => 'nullable|string',
            'bank_transfer_enabled' => 'nullable|boolean',
            'bank_name' => 'nullable|string',
            'account_name' => 'nullable|string',
            'account_number' => 'nullable|string',
        ]);

        // Save each setting to database
        $this->saveSetting('currency', $request->currency, 'string', 'payment');
        $this->saveSetting('currency_symbol', $request->currency_symbol, 'string', 'payment');
        $this->saveSetting('currency_position', $request->currency_position, 'string', 'payment');
        $this->saveSetting('paystack_enabled', $request->has('paystack_enabled'), 'boolean', 'payment');
        $this->saveSetting('paystack_public_key', $request->paystack_public_key, 'string', 'payment');
        $this->saveSetting('paystack_secret_key', $request->paystack_secret_key, 'string', 'payment');
        $this->saveSetting('flutterwave_enabled', $request->has('flutterwave_enabled'), 'boolean', 'payment');
        $this->saveSetting('flutterwave_public_key', $request->flutterwave_public_key, 'string', 'payment');
        $this->saveSetting('flutterwave_secret_key', $request->flutterwave_secret_key, 'string', 'payment');
        $this->saveSetting('bank_transfer_enabled', $request->has('bank_transfer_enabled'), 'boolean', 'payment');
        $this->saveSetting('bank_name', $request->bank_name, 'string', 'payment');
        $this->saveSetting('account_name', $request->account_name, 'string', 'payment');
        $this->saveSetting('account_number', $request->account_number, 'string', 'payment');

        // Clear the settings cache
        SettingsHelper::all();

        return redirect()->route('admin.settings.index', ['tab' => 'payment'])
            ->with('success', 'Payment settings updated successfully.');
    }

    /**
     * Update shipping settings.
     */
   /**
 * Update shipping settings.
 */
/**
 * Update shipping settings.
 */
public function updateShipping(Request $request)
{
    // Log the incoming request data
    \Log::info('=== SHIPPING SETTINGS UPDATE STARTED ===');
    \Log::info('Request data:', $request->all());
    
    $request->validate([
        'free_shipping_enabled' => 'nullable',
        'free_shipping_label' => 'nullable|string|max:255',
        'free_shipping_min_amount' => 'nullable|numeric|min:0',
        'flat_rate_enabled' => 'nullable',
        'flat_rate_label' => 'nullable|string|max:255',
        'flat_rate_amount' => 'nullable|numeric|min:0',
        'local_pickup_enabled' => 'nullable',
        'local_pickup_address' => 'nullable|string|max:500',
    ]);

    try {
        // Save each setting to database with detailed logging
        $this->saveSettingWithDebug('free_shipping_enabled', $request->has('free_shipping_enabled'), 'boolean', 'shipping');
        $this->saveSettingWithDebug('free_shipping_label', $request->free_shipping_label, 'string', 'shipping');
        $this->saveSettingWithDebug('free_shipping_min_amount', $request->free_shipping_min_amount, 'integer', 'shipping');
        $this->saveSettingWithDebug('flat_rate_enabled', $request->has('flat_rate_enabled'), 'boolean', 'shipping');
        $this->saveSettingWithDebug('flat_rate_label', $request->flat_rate_label, 'string', 'shipping');
        $this->saveSettingWithDebug('flat_rate_amount', $request->flat_rate_amount, 'integer', 'shipping');
        $this->saveSettingWithDebug('local_pickup_enabled', $request->has('local_pickup_enabled'), 'boolean', 'shipping');
        $this->saveSettingWithDebug('local_pickup_address', $request->local_pickup_address, 'string', 'shipping');

        // Clear the settings cache
        if (class_exists('App\Helpers\SettingsHelper')) {
            \App\Helpers\SettingsHelper::clearCache();
            \Log::info('Settings cache cleared');
        }

        \Log::info('=== SHIPPING SETTINGS UPDATE COMPLETED SUCCESSFULLY ===');

        return redirect()->route('admin.settings.index', ['tab' => 'shipping'])
            ->with('success', 'Shipping settings updated successfully.');

    } catch (\Exception $e) {
        \Log::error('ERROR UPDATING SHIPPING SETTINGS: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return redirect()->back()
            ->with('error', 'Error updating shipping settings: ' . $e->getMessage())
            ->withInput();
    }
}

/**
 * Debug version of saveSetting
 */
private function saveSettingWithDebug($key, $value, $type = 'string', $group = 'general')
{
    \Log::info("Saving setting: {$key}");
    \Log::info("Original value: " . json_encode($value));
    \Log::info("Type: {$type}");
    \Log::info("Group: {$group}");
    
    // Handle checkbox values
    if ($value === 'on') {
        $value = true;
        \Log::info("Converted 'on' to boolean true");
    } elseif ($value === 'off') {
        $value = false;
        \Log::info("Converted 'off' to boolean false");
    }

    // Convert boolean to string for storage
    if (is_bool($value)) {
        $value = $value ? '1' : '0';
        \Log::info("Converted boolean to string: {$value}");
    }

    // Handle null values
    if ($value === null) {
        $value = '';
        \Log::info("Converted null to empty string");
    }

    try {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'label' => $this->getLabelForSetting($key),
                'is_public' => $this->isPublicSetting($key)
            ]
        );
        
        \Log::info("Setting saved successfully. ID: {$setting->id}, Value: {$setting->value}");
        
    } catch (\Exception $e) {
        \Log::error("Error saving setting {$key}: " . $e->getMessage());
        throw $e;
    }
}

    /**
     * Helper method to save a setting
     */
    private function saveSetting($key, $value, $type = 'string', $group = 'general')
    {
        // Handle checkbox values
        if ($value === 'on') {
            $value = true;
        } elseif ($value === 'off') {
            $value = false;
        }

        // Convert boolean to string for storage
        if (is_bool($value)) {
            $value = $value ? '1' : '0';
        }

        Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'label' => $this->getLabelForSetting($key),
                'is_public' => $this->isPublicSetting($key)
            ]
        );
    }

    /**
     * Get label for a setting key
     */
    private function getLabelForSetting($key)
    {
        $labels = [
            // General settings
            'site_title' => 'Site Title',
            'site_description' => 'Site Description',
            'admin_email' => 'Admin Email',
            'timezone' => 'Timezone',
            'date_format' => 'Date Format',
            'time_format' => 'Time Format',
            'maintenance_mode' => 'Maintenance Mode',
            
            // Store settings
            'store_name' => 'Store Name',
            'store_phone' => 'Phone Number',
            'store_phone_alt' => 'Alternative Phone',
            'whatsapp_number' => 'WhatsApp Number',
            'store_email' => 'Store Email',
            'support_email' => 'Support Email',
            'store_address' => 'Store Address',
            'store_city' => 'City',
            'store_state' => 'State',
            'store_country' => 'Country',
            'store_postal' => 'Postal Code',
            'working_hours_weekdays' => 'Weekday Hours',
            'working_hours_weekend' => 'Weekend Hours',
            
            // Payment settings
            'currency' => 'Currency',
            'currency_symbol' => 'Currency Symbol',
            'currency_position' => 'Currency Position',
            'paystack_enabled' => 'Paystack Enabled',
            'paystack_public_key' => 'Paystack Public Key',
            'paystack_secret_key' => 'Paystack Secret Key',
            'flutterwave_enabled' => 'Flutterwave Enabled',
            'flutterwave_public_key' => 'Flutterwave Public Key',
            'flutterwave_secret_key' => 'Flutterwave Secret Key',
            'bank_transfer_enabled' => 'Bank Transfer Enabled',
            'bank_name' => 'Bank Name',
            'account_name' => 'Account Name',
            'account_number' => 'Account Number',
            
            // Shipping settings
            'free_shipping_enabled' => 'Free Shipping Enabled',
            'free_shipping_label' => 'Free Shipping Label',
            'free_shipping_min_amount' => 'Free Shipping Minimum Amount',
            'flat_rate_enabled' => 'Flat Rate Enabled',
            'flat_rate_label' => 'Flat Rate Label',
            'flat_rate_amount' => 'Flat Rate Amount',
            'local_pickup_enabled' => 'Local Pickup Enabled',
            'local_pickup_address' => 'Local Pickup Address',
        ];

        return $labels[$key] ?? ucwords(str_replace('_', ' ', $key));
    }

    /**
     * Determine if a setting should be public
     */
    private function isPublicSetting($key)
    {
        $privateKeys = [
            'admin_email',
            'paystack_secret_key',
            'flutterwave_secret_key',
            'paystack_public_key',
            'flutterwave_public_key',
            'account_number',
            'maintenance_mode',
        ];

        return !in_array($key, $privateKeys);
    }
}