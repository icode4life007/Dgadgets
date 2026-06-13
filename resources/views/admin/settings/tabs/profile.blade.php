<form action="{{ route('admin.settings.profile') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Avatar Upload -->
        <div class="md:w-1/3">
            <div class="bg-gray-50 rounded-xl p-6 text-center">
                <div class="mb-4">
                    <div class="w-32 h-32 mx-auto bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-4xl font-bold">{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</span>
                    </div>
                </div>
                <h4 class="font-semibold text-gray-800 mb-1">{{ Auth::guard('admin')->user()->name }}</h4>
                <p class="text-sm text-gray-500 mb-4">{{ Auth::guard('admin')->user()->email }}</p>
                
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-purple-500 transition cursor-pointer"
                     onclick="document.getElementById('avatar').click()">
                    <input type="file" id="avatar" name="avatar" class="hidden" accept="image/jpeg,image/png,image/jpg,image/webp">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600">Click to upload avatar</p>
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, WEBP (Max 2MB)</p>
                </div>
            </div>
        </div>
        
        <!-- Profile Form -->
<div class="md:w-2/3">
    <h4 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h4>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
            <input type="text" name="name" value="{{ old('name', Auth::guard('admin')->user()->name) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" name="email" value="{{ old('email', Auth::guard('admin')->user()->email) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
            <input type="tel" name="phone" value="{{ old('phone', Auth::guard('admin')->user()->phone ?? '+234 800 000 0000') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
            <input type="text" name="job_title" value="{{ old('job_title', Auth::guard('admin')->user()->job_title ?? 'Administrator') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
            <textarea name="bio" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">{{ old('bio', Auth::guard('admin')->user()->bio ?? '') }}</textarea>
        </div>
    </div>
    
    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-save mr-2"></i> Update Profile
        </button>
    </div>
</div>
    </div>
</form>