<form action="{{ route('admin.settings.payment') }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="space-y-6">
        <!-- Currency Settings -->
        <div>
            <h4 class="text-md font-semibold text-gray-700 mb-4">Currency Settings</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                    <select name="currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                        <option value="NGN" selected>Nigerian Naira (₦)</option>
                        <option value="USD">US Dollar ($)</option>
                        <option value="EUR">Euro (€)</option>
                        <option value="GBP">British Pound (£)</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency Symbol</label>
                    <input type="text" name="currency_symbol" value="₦" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency Position</label>
                    <select name="currency_position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                        <option value="left" selected>Left (₦1,000)</option>
                        <option value="right">Right (1,000₦)</option>
                        <option value="left_space">Left with space (₦ 1,000)</option>
                        <option value="right_space">Right with space (1,000 ₦)</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Payment Gateways -->
        <div class="pt-6 border-t border-gray-200">
            <h4 class="text-md font-semibold text-gray-700 mb-4">Payment Gateways</h4>
            
            <div class="space-y-4">
                <!-- Paystack -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="https://paystack.com/assets/img/logo.svg" alt="Paystack" class="h-8">
                            <span class="ml-3 font-medium">Paystack</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="paystack_enabled" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-purple-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-4">
                        <input type="text" name="paystack_public_key" placeholder="Public Key" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                        <input type="text" name="paystack_secret_key" placeholder="Secret Key" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                    </div>
                </div>
                
                <!-- Flutterwave -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="https://flutterwave.com/images/logo/favicon.png" alt="Flutterwave" class="h-8">
                            <span class="ml-3 font-medium">Flutterwave</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="flutterwave_enabled" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-purple-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-4">
                        <input type="text" name="flutterwave_public_key" placeholder="Public Key" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                        <input type="text" name="flutterwave_secret_key" placeholder="Secret Key" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                    </div>
                </div>
                
                <!-- Bank Transfer -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-university text-2xl text-gray-600 mr-3"></i>
                            <span class="font-medium">Bank Transfer</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="bank_transfer_enabled" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-purple-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    <div class="mt-3 space-y-3">
                        <input type="text" name="bank_name" placeholder="Bank Name" value="First Bank of Nigeria" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" name="account_name" placeholder="Account Name" value="Dominion Gadget Ltd" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                            <input type="text" name="account_number" placeholder="Account Number" value="1234567890" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-purple-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-save mr-2"></i> Save Payment Settings
        </button>
    </div>
</form>