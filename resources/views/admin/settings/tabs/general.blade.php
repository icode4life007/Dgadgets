<form action="{{ route('admin.settings.general') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Logo Upload -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Site Logo</label>
            <div class="flex items-center space-x-6">
                <div class="flex-shrink-0">
                    <div id="logo_preview_container" class="relative">
                        @if (setting('site_logo'))
                            <img id="logo_preview" src="{{ asset(setting('site_logo')) }}" alt="Site Logo Preview"
                                class="h-20 w-auto object-contain border rounded-lg p-2">
                        @else
                            <div id="logo_preview_placeholder" class="h-20 w-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-3xl text-gray-400"></i>
                            </div>
                            <img id="logo_preview" src="#" alt="Site Logo Preview" 
                                class="h-20 w-auto object-contain border rounded-lg p-2 hidden">
                        @endif
                        <button type="button" id="logo_remove" 
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition {{ setting('site_logo') ? '' : 'hidden' }}"
                            onclick="removeLogo()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-purple-500 transition cursor-pointer"
                        onclick="document.getElementById('site_logo').click()">
                        <input type="file" id="site_logo" name="site_logo" class="hidden"
                            accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml"
                            onchange="previewImage(this, 'logo')">
                        <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600">Click to upload logo</p>
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG, WEBP, SVG (Max 2MB)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Favicon Upload -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
            <div class="flex items-center space-x-6">
                <div class="flex-shrink-0">
                    <div id="favicon_preview_container" class="relative">
                        @if (setting('site_favicon'))
                            <img id="favicon_preview" src="{{ asset(setting('site_favicon')) }}" alt="Favicon Preview"
                                class="h-12 w-12 object-contain border rounded-lg p-1">
                        @else
                            <div id="favicon_preview_placeholder" class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-star text-2xl text-gray-400"></i>
                            </div>
                            <img id="favicon_preview" src="#" alt="Favicon Preview" 
                                class="h-12 w-12 object-contain border rounded-lg p-1 hidden">
                        @endif
                        <button type="button" id="favicon_remove" 
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 transition {{ setting('site_favicon') ? '' : 'hidden' }}"
                            onclick="removeFavicon()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-purple-500 transition cursor-pointer"
                        onclick="document.getElementById('site_favicon').click()">
                        <input type="file" id="site_favicon" name="site_favicon" class="hidden"
                            accept="image/x-icon,image/png,image/svg+xml,image/jpeg,image/jpg"
                            onchange="previewImage(this, 'favicon')">
                        <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600">Click to upload favicon</p>
                        <p class="text-xs text-gray-500 mt-1">ICO, PNG, SVG (Max 1MB) - 32x32px or 16x16px</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Site Title</label>
            <input type="text" name="site_title"
                value="{{ old('site_title', $settings['site_title']->value ?? config('app.name')) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
            <input type="text" name="site_description"
                value="{{ old('site_description', $settings['site_description']->value ?? 'Your premier gadget store') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Admin Email</label>
            <input type="email" name="admin_email"
                value="{{ old('admin_email', $settings['admin_email']->value ?? 'admin@dominiangadget.com') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
            <select name="timezone"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                <option value="Africa/Lagos"
                    {{ old('timezone', $settings['timezone']->value ?? 'Africa/Lagos') == 'Africa/Lagos' ? 'selected' : '' }}>
                    Africa/Lagos (WAT)</option>
                <option value="Africa/Cairo"
                    {{ old('timezone', $settings['timezone']->value ?? '') == 'Africa/Cairo' ? 'selected' : '' }}>
                    Africa/Cairo (EET)</option>
                <option value="Africa/Johannesburg"
                    {{ old('timezone', $settings['timezone']->value ?? '') == 'Africa/Johannesburg' ? 'selected' : '' }}>
                    Africa/Johannesburg (SAST)</option>
                <option value="Africa/Nairobi"
                    {{ old('timezone', $settings['timezone']->value ?? '') == 'Africa/Nairobi' ? 'selected' : '' }}>
                    Africa/Nairobi (EAT)</option>
                <option value="UTC"
                    {{ old('timezone', $settings['timezone']->value ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
            <select name="date_format"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                <option value="Y-m-d"
                    {{ old('date_format', $settings['date_format']->value ?? 'Y-m-d') == 'Y-m-d' ? 'selected' : '' }}>
                    YYYY-MM-DD (2024-01-15)</option>
                <option value="d/m/Y"
                    {{ old('date_format', $settings['date_format']->value ?? '') == 'd/m/Y' ? 'selected' : '' }}>
                    DD/MM/YYYY (15/01/2024)</option>
                <option value="m/d/Y"
                    {{ old('date_format', $settings['date_format']->value ?? '') == 'm/d/Y' ? 'selected' : '' }}>
                    MM/DD/YYYY (01/15/2024)</option>
                <option value="F j, Y"
                    {{ old('date_format', $settings['date_format']->value ?? '') == 'F j, Y' ? 'selected' : '' }}>
                    January 15, 2024</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Time Format</label>
            <select name="time_format"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                <option value="H:i"
                    {{ old('time_format', $settings['time_format']->value ?? 'H:i') == 'H:i' ? 'selected' : '' }}>
                    24-hour (14:30)</option>
                <option value="h:i A"
                    {{ old('time_format', $settings['time_format']->value ?? '') == 'h:i A' ? 'selected' : '' }}>
                    12-hour (02:30 PM)</option>
            </select>
        </div>
    </div>

    <div class="mt-6 pt-6 border-t border-gray-200">
        <h4 class="text-md font-semibold text-gray-700 mb-4">Maintenance Mode</h4>
        <div class="flex items-center">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="maintenance_mode" class="sr-only peer"
                    {{ old('maintenance_mode', $settings['maintenance_mode']->value ?? false) ? 'checked' : '' }}>
                <div
                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-purple-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600">
                </div>
                <span class="ml-3 text-sm font-medium text-gray-700">Enable Maintenance Mode</span>
            </label>
        </div>
        <p class="text-xs text-gray-500 mt-2">When enabled, only admins can access the site. Visitors will see a
            maintenance page.</p>
    </div>

    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-save mr-2"></i> Save Settings
        </button>
    </div>
</form>

@push('scripts')
<script>
// Preview image function
function previewImage(input, type) {
    const preview = document.getElementById(type + '_preview');
    const placeholder = document.getElementById(type + '_preview_placeholder');
    const removeBtn = document.getElementById(type + '_remove');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) {
                placeholder.classList.add('hidden');
            }
            removeBtn.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove logo
function removeLogo() {
    const input = document.getElementById('site_logo');
    const preview = document.getElementById('logo_preview');
    const placeholder = document.getElementById('logo_preview_placeholder');
    const removeBtn = document.getElementById('logo_remove');
    
    input.value = '';
    preview.src = '#';
    preview.classList.add('hidden');
    if (placeholder) {
        placeholder.classList.remove('hidden');
    }
    removeBtn.classList.add('hidden');
    
    // Optional: Add a hidden input to mark logo for deletion
    // You can handle this in your controller
    let deleteInput = document.getElementById('delete_logo');
    if (!deleteInput) {
        deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'delete_logo';
        deleteInput.id = 'delete_logo';
        deleteInput.value = '1';
        document.querySelector('form').appendChild(deleteInput);
    }
}

// Remove favicon
function removeFavicon() {
    const input = document.getElementById('site_favicon');
    const preview = document.getElementById('favicon_preview');
    const placeholder = document.getElementById('favicon_preview_placeholder');
    const removeBtn = document.getElementById('favicon_remove');
    
    input.value = '';
    preview.src = '#';
    preview.classList.add('hidden');
    if (placeholder) {
        placeholder.classList.remove('hidden');
    }
    removeBtn.classList.add('hidden');
    
    // Optional: Add a hidden input to mark favicon for deletion
    let deleteInput = document.getElementById('delete_favicon');
    if (!deleteInput) {
        deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'delete_favicon';
        deleteInput.id = 'delete_favicon';
        deleteInput.value = '1';
        document.querySelector('form').appendChild(deleteInput);
    }
}

// Handle drag and drop (optional enhancement)
document.querySelectorAll('.border-dashed').forEach(area => {
    area.addEventListener('dragover', (e) => {
        e.preventDefault();
        area.classList.add('border-purple-500', 'bg-purple-50');
    });
    
    area.addEventListener('dragleave', (e) => {
        e.preventDefault();
        area.classList.remove('border-purple-500', 'bg-purple-50');
    });
    
    area.addEventListener('drop', (e) => {
        e.preventDefault();
        area.classList.remove('border-purple-500', 'bg-purple-50');
        
        const files = e.dataTransfer.files;
        const input = area.querySelector('input[type="file"]');
        if (input && files.length > 0) {
            input.files = files;
            // Trigger change event
            const event = new Event('change', { bubbles: true });
            input.dispatchEvent(event);
        }
    });
});
</script>

<style>
/* Smooth transitions */
.border-dashed {
    transition: all 0.3s ease;
}

/* Preview image hover effect */
#logo_preview_container img, #favicon_preview_container img {
    transition: transform 0.2s ease;
}

#logo_preview_container img:hover, #favicon_preview_container img:hover {
    transform: scale(1.05);
}

/* Remove button styling */
#logo_remove, #favicon_remove {
    transition: all 0.2s ease;
    opacity: 0.8;
}

#logo_remove:hover, #favicon_remove:hover {
    opacity: 1;
    transform: scale(1.1);
}
</style>
@endpush