<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_title',
                'value' => 'Dominion Gadget & Accessories',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Title',
                'description' => 'The title of your website',
                'sort_order' => 1,
                'is_public' => true
            ],
            [
                'key' => 'site_description',
                'value' => 'Your premier gadget store',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'Brief description of your site',
                'sort_order' => 2,
                'is_public' => true
            ],
            [
                'key' => 'site_logo',
                'value' => '',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Logo',
                'description' => 'Website logo for header and branding',
                'sort_order' => 3,
                'is_public' => true
            ],
            [
                'key' => 'site_favicon',
                'value' => '',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Favicon',
                'description' => 'Website favicon (icon in browser tab)',
                'sort_order' => 4,
                'is_public' => true
            ],
            [
                'key' => 'admin_email',
                'value' => 'admin@dominiangadget.com',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Admin Email',
                'description' => 'Primary admin email address',
                'sort_order' => 5,
                'is_public' => false
            ],
            [
                'key' => 'timezone',
                'value' => 'Africa/Lagos',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Timezone',
                'description' => 'Default timezone for the site',
                'sort_order' => 6,
                'is_public' => false
            ],
            [
                'key' => 'date_format',
                'value' => 'Y-m-d',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Date Format',
                'description' => 'Format for displaying dates',
                'sort_order' => 7,
                'is_public' => true
            ],
            [
                'key' => 'time_format',
                'value' => 'H:i',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Time Format',
                'description' => 'Format for displaying time',
                'sort_order' => 8,
                'is_public' => true
            ],
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Maintenance Mode',
                'description' => 'Enable maintenance mode',
                'sort_order' => 9,
                'is_public' => false
            ],

            // Store Information
            [
                'key' => 'store_name',
                'value' => 'Dominion Gadget & Accessories',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Store Name',
                'description' => 'Your store name',
                'sort_order' => 1,
                'is_public' => true
            ],
            [
                'key' => 'store_phone',
                'value' => '+234 800 000 0000',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Phone Number',
                'description' => 'Primary store phone number',
                'sort_order' => 2,
                'is_public' => true
            ],
            [
                'key' => 'store_phone_alt',
                'value' => '+234 800 000 0001',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Alternative Phone',
                'description' => 'Secondary phone number',
                'sort_order' => 3,
                'is_public' => true
            ],
            [
                'key' => 'store_email',
                'value' => 'info@dominiangadget.com',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Store Email',
                'description' => 'Primary store email',
                'sort_order' => 4,
                'is_public' => true
            ],
            [
                'key' => 'support_email',
                'value' => 'support@dominiangadget.com',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Support Email',
                'description' => 'Customer support email',
                'sort_order' => 5,
                'is_public' => true
            ],
            [
                'key' => 'store_address',
                'value' => '123 Gadget Street, Lagos, Nigeria',
                'type' => 'text',
                'group' => 'store',
                'label' => 'Store Address',
                'description' => 'Physical store address',
                'sort_order' => 6,
                'is_public' => true
            ],
            [
                'key' => 'store_city',
                'value' => 'Lagos',
                'type' => 'string',
                'group' => 'store',
                'label' => 'City',
                'description' => 'Store city',
                'sort_order' => 7,
                'is_public' => true
            ],
            [
                'key' => 'store_state',
                'value' => 'Lagos',
                'type' => 'string',
                'group' => 'store',
                'label' => 'State',
                'description' => 'Store state/province',
                'sort_order' => 8,
                'is_public' => true
            ],
            [
                'key' => 'store_country',
                'value' => 'Nigeria',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Country',
                'description' => 'Store country',
                'sort_order' => 9,
                'is_public' => true
            ],
            [
                'key' => 'store_postal',
                'value' => '100001',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Postal Code',
                'description' => 'Store postal/zip code',
                'sort_order' => 10,
                'is_public' => true
            ],
            [
                'key' => 'working_hours_weekdays',
                'value' => 'Mon - Fri: 9AM - 6PM',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Weekday Hours',
                'description' => 'Monday to Friday working hours',
                'sort_order' => 11,
                'is_public' => true
            ],
            [
                'key' => 'working_hours_weekend',
                'value' => 'Sat: 10AM - 4PM, Sun: Closed',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Weekend Hours',
                'description' => 'Saturday and Sunday hours',
                'sort_order' => 12,
                'is_public' => true
            ],

            // Payment Settings
            [
                'key' => 'currency',
                'value' => 'NGN',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Currency',
                'description' => 'Default store currency',
                'sort_order' => 1,
                'is_public' => true
            ],
            [
                'key' => 'currency_symbol',
                'value' => '₦',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Currency Symbol',
                'description' => 'Currency symbol to display',
                'sort_order' => 2,
                'is_public' => true
            ],
            [
                'key' => 'currency_position',
                'value' => 'left',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Currency Position',
                'description' => 'Position of currency symbol (left, right, left_space, right_space)',
                'sort_order' => 3,
                'is_public' => true
            ],
            [
                'key' => 'paystack_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'payment',
                'label' => 'Paystack Enabled',
                'description' => 'Enable Paystack payment gateway',
                'sort_order' => 4,
                'is_public' => false
            ],
            [
                'key' => 'paystack_public_key',
                'value' => '',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Paystack Public Key',
                'description' => 'Paystack public API key',
                'sort_order' => 5,
                'is_public' => false
            ],
            [
                'key' => 'paystack_secret_key',
                'value' => '',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Paystack Secret Key',
                'description' => 'Paystack secret API key',
                'sort_order' => 6,
                'is_public' => false
            ],
            [
                'key' => 'flutterwave_enabled',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'payment',
                'label' => 'Flutterwave Enabled',
                'description' => 'Enable Flutterwave payment gateway',
                'sort_order' => 7,
                'is_public' => false
            ],
            [
                'key' => 'flutterwave_public_key',
                'value' => '',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Flutterwave Public Key',
                'description' => 'Flutterwave public API key',
                'sort_order' => 8,
                'is_public' => false
            ],
            [
                'key' => 'flutterwave_secret_key',
                'value' => '',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Flutterwave Secret Key',
                'description' => 'Flutterwave secret API key',
                'sort_order' => 9,
                'is_public' => false
            ],
            [
                'key' => 'bank_transfer_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'payment',
                'label' => 'Bank Transfer Enabled',
                'description' => 'Enable bank transfer payment method',
                'sort_order' => 10,
                'is_public' => true
            ],
            [
                'key' => 'bank_name',
                'value' => 'First Bank of Nigeria',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Bank Name',
                'description' => 'Bank name for transfers',
                'sort_order' => 11,
                'is_public' => true
            ],
            [
                'key' => 'account_name',
                'value' => 'Dominion Gadget Ltd',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Account Name',
                'description' => 'Bank account name',
                'sort_order' => 12,
                'is_public' => true
            ],
            [
                'key' => 'account_number',
                'value' => '1234567890',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Account Number',
                'description' => 'Bank account number',
                'sort_order' => 13,
                'is_public' => true
            ],

            // Shipping Settings
            [
                'key' => 'free_shipping_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'shipping',
                'label' => 'Free Shipping Enabled',
                'description' => 'Enable free shipping option',
                'sort_order' => 1,
                'is_public' => true
            ],
            [
                'key' => 'free_shipping_label',
                'value' => 'Free Shipping',
                'type' => 'string',
                'group' => 'shipping',
                'label' => 'Free Shipping Label',
                'description' => 'Label for free shipping',
                'sort_order' => 2,
                'is_public' => true
            ],
            [
                'key' => 'free_shipping_min_amount',
                'value' => '50000',
                'type' => 'integer',
                'group' => 'shipping',
                'label' => 'Free Shipping Minimum',
                'description' => 'Minimum order amount for free shipping',
                'sort_order' => 3,
                'is_public' => true
            ],
            [
                'key' => 'flat_rate_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'shipping',
                'label' => 'Flat Rate Enabled',
                'description' => 'Enable flat rate shipping',
                'sort_order' => 4,
                'is_public' => true
            ],
            [
                'key' => 'flat_rate_label',
                'value' => 'Standard Shipping',
                'type' => 'string',
                'group' => 'shipping',
                'label' => 'Flat Rate Label',
                'description' => 'Label for flat rate shipping',
                'sort_order' => 5,
                'is_public' => true
            ],
            [
                'key' => 'flat_rate_amount',
                'value' => '2500',
                'type' => 'integer',
                'group' => 'shipping',
                'label' => 'Flat Rate Amount',
                'description' => 'Flat rate shipping amount',
                'sort_order' => 6,
                'is_public' => true
            ],
            [
                'key' => 'local_pickup_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'shipping',
                'label' => 'Local Pickup Enabled',
                'description' => 'Enable local pickup option',
                'sort_order' => 7,
                'is_public' => true
            ],
            [
                'key' => 'local_pickup_address',
                'value' => '123 Gadget Street, Lagos',
                'type' => 'text',
                'group' => 'shipping',
                'label' => 'Local Pickup Address',
                'description' => 'Address for local pickup',
                'sort_order' => 8,
                'is_public' => true
            ],

            // Social Media Links
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/dominiangadget',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Facebook page URL',
                'sort_order' => 1,
                'is_public' => true
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/dominiangadget',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Twitter/X profile URL',
                'sort_order' => 2,
                'is_public' => true
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/dominiangadget',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Instagram profile URL',
                'sort_order' => 3,
                'is_public' => true
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '+2348000000000',
                'type' => 'string',
                'group' => 'social',
                'label' => 'WhatsApp Number',
                'description' => 'WhatsApp business number',
                'sort_order' => 4,
                'is_public' => true
            ],
            [
                'key' => 'whatsapp_message',
                'value' => 'Hello, I have a question about a product.',
                'type' => 'string',
                'group' => 'social',
                'label' => 'WhatsApp Default Message',
                'description' => 'Default message for WhatsApp',
                'sort_order' => 5,
                'is_public' => true
            ],

            // Email Settings
            [
                'key' => 'mail_driver',
                'value' => 'smtp',
                'type' => 'string',
                'group' => 'email',
                'label' => 'Mail Driver',
                'description' => 'Email sending driver',
                'sort_order' => 1,
                'is_public' => false
            ],
            [
                'key' => 'mail_host',
                'value' => 'smtp.mailtrap.io',
                'type' => 'string',
                'group' => 'email',
                'label' => 'Mail Host',
                'description' => 'SMTP host',
                'sort_order' => 2,
                'is_public' => false
            ],
            [
                'key' => 'mail_port',
                'value' => '2525',
                'type' => 'integer',
                'group' => 'email',
                'label' => 'Mail Port',
                'description' => 'SMTP port',
                'sort_order' => 3,
                'is_public' => false
            ],
            [
                'key' => 'mail_username',
                'value' => '',
                'type' => 'string',
                'group' => 'email',
                'label' => 'Mail Username',
                'description' => 'SMTP username',
                'sort_order' => 4,
                'is_public' => false
            ],
            [
                'key' => 'mail_password',
                'value' => '',
                'type' => 'string',
                'group' => 'email',
                'label' => 'Mail Password',
                'description' => 'SMTP password',
                'sort_order' => 5,
                'is_public' => false
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'tls',
                'type' => 'string',
                'group' => 'email',
                'label' => 'Mail Encryption',
                'description' => 'SMTP encryption (tls/ssl)',
                'sort_order' => 6,
                'is_public' => false
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'noreply@dominiangadget.com',
                'type' => 'string',
                'group' => 'email',
                'label' => 'From Address',
                'description' => 'Default from email address',
                'sort_order' => 7,
                'is_public' => false
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'Dominion Gadget & Accessories',
                'type' => 'string',
                'group' => 'email',
                'label' => 'From Name',
                'description' => 'Default from name',
                'sort_order' => 8,
                'is_public' => false
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}