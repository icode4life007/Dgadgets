<form action="{{ route('admin.settings.shipping') }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="space-y-6">
        <!-- Shipping Methods -->
        <div>
            <h4 class="text-md font-semibold text-gray-700 mb-4">Shipping Methods</h4>
            
            <div class="space-y-4">
                <!-- Free Shipping -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-gift text-2xl text-green-600 mr-3"></i>
                            <div>
                                <span class="font-medium">Free Shipping</span>
                                <p class="text-xs text-gray-500">Free shipping on orders over a certain amount</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="free_shipping_enabled" class="sr-only peer" 
                                   {{ (old('free_shipping_enabled', $settings['free_shipping_enabled']->value ?? false) ? 'checked' : '') }}>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-purple-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-4">
                        <input type="text" name="free_shipping_label" placeholder="Label" 
                               value="{{ old('free_shipping_label', $settings['free_shipping_label']->value ?? 'Free Shipping') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                        <input type="number" name="free_shipping_min_amount" placeholder="Minimum Order Amount" 
                               value="{{ old('free_shipping_min_amount', $settings['free_shipping_min_amount']->value ?? 50000) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                    </div>
                </div>
                
                <!-- Flat Rate -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-box text-2xl text-blue-600 mr-3"></i>
                            <div>
                                <span class="font-medium">Flat Rate</span>
                                <p class="text-xs text-gray-500">Fixed shipping rate for all orders</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="flat_rate_enabled" class="sr-only peer" 
                                   {{ (old('flat_rate_enabled', $settings['flat_rate_enabled']->value ?? true) ? 'checked' : '') }}>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-purple-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-4">
                        <input type="text" name="flat_rate_label" placeholder="Label" 
                               value="{{ old('flat_rate_label', $settings['flat_rate_label']->value ?? 'Standard Shipping') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                        <input type="number" name="flat_rate_amount" placeholder="Amount" 
                               value="{{ old('flat_rate_amount', $settings['flat_rate_amount']->value ?? 2500) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                    </div>
                </div>
                
                <!-- Local Pickup -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-store-alt text-2xl text-purple-600 mr-3"></i>
                            <div>
                                <span class="font-medium">Local Pickup</span>
                                <p class="text-xs text-gray-500">Customer picks up from store</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="local_pickup_enabled" class="sr-only peer" 
                                   {{ (old('local_pickup_enabled', $settings['local_pickup_enabled']->value ?? true) ? 'checked' : '') }}>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-purple-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    <div class="mt-3">
                        <input type="text" name="local_pickup_address" placeholder="Pickup Address" 
                               value="{{ old('local_pickup_address', $settings['local_pickup_address']->value ?? '123 Gadget Street, Lagos') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-save mr-2"></i> Save Shipping Settings
        </button>
    </div>
</form>