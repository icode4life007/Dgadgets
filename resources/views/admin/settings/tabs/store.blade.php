<form action="{{ route('admin.settings.store') }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Store Name</label>
            <input type="text" name="store_name" 
                   value="{{ old('store_name', $settings['store_name']->value ?? 'Dominion Gadget & Accessories') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
            <input type="tel" name="store_phone" 
                   value="{{ old('store_phone', $settings['store_phone']->value ?? '+234 800 000 0000') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Alternative Phone</label>
            <input type="tel" name="store_phone_alt" 
                   value="{{ old('store_phone_alt', $settings['store_phone_alt']->value ?? '+234 800 000 0001') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <!-- WhatsApp Number Field - NEW -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fab fa-whatsapp text-green-500"></i>
                </div>
                <input type="tel" name="whatsapp_number" 
                       value="{{ old('whatsapp_number', $settings['whatsapp_number']->value ?? '+2348000000000') }}" 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                       placeholder="+2348000000000">
            </div>
            <p class="text-xs text-gray-500 mt-1">Format: +2348000000000 (no spaces)</p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" name="store_email" 
                   value="{{ old('store_email', $settings['store_email']->value ?? 'info@dominiangadget.com') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Support Email</label>
            <input type="email" name="support_email" 
                   value="{{ old('support_email', $settings['support_email']->value ?? 'support@dominiangadget.com') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
            <textarea name="store_address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">{{ old('store_address', $settings['store_address']->value ?? '123 Gadget Street, Lagos, Nigeria') }}</textarea>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
            <input type="text" name="store_city" 
                   value="{{ old('store_city', $settings['store_city']->value ?? 'Lagos') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
            <input type="text" name="store_state" 
                   value="{{ old('store_state', $settings['store_state']->value ?? 'Lagos') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
            <input type="text" name="store_country" 
                   value="{{ old('store_country', $settings['store_country']->value ?? 'Nigeria') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
            <input type="text" name="store_postal" 
                   value="{{ old('store_postal', $settings['store_postal']->value ?? '100001') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Working Hours</label>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="working_hours_weekdays" 
                       value="{{ old('working_hours_weekdays', $settings['working_hours_weekdays']->value ?? 'Mon - Fri: 9AM - 6PM') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                       placeholder="Weekdays">
                <input type="text" name="working_hours_weekend" 
                       value="{{ old('working_hours_weekend', $settings['working_hours_weekend']->value ?? 'Sat: 10AM - 4PM, Sun: Closed') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                       placeholder="Weekends">
            </div>
        </div>
    </div>
    
    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-save mr-2"></i> Save Store Information
        </button>
    </div>
</form>