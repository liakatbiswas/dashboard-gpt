<x-app-layout title="NGHS || Site Settings">
    <div
        class="bg-white dark:bg-gray-800 p-6 min-h-[calc(100vh-180px)] shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 transition-colors duration-300">

        <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-5">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Site Settings</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Manage your school identity and contact information.
            </p>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Settings -->
                <div>
                    <label for="site_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site
                        Title <span class="text-red-500 dark:text-red-400">*</span></label>
                    <input id="site_title" name="site_title" type="text"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2.5 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                        value="{{ old('site_title', $setting->site_title) }}" required maxlength="150">
                </div>

                <div>
                    <label for="site_subtitle"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site Subtitle</label>
                    <input id="site_subtitle" name="site_subtitle" type="text"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2.5 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                        value="{{ old('site_subtitle', $setting->site_subtitle) }}">
                </div>

                <div>
                    <label for="site_tagline"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tagline</label>
                    <input id="site_tagline" name="site_tagline" type="text"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2.5 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                        value="{{ old('site_tagline', $setting->site_tagline) }}">
                </div>

                <div>
                    <label for="phone"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                    <input id="phone" name="phone" type="text"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2.5 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                        value="{{ old('phone', $setting->phone) }}">
                </div>

                <div>
                    <label for="email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input id="email" name="email" type="email"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2.5 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                        value="{{ old('email', $setting->email) }}">
                </div>

                <div>
                    <label for="website"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Website URL</label>
                    <input id="website" name="website" type="url"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2.5 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                        value="{{ old('website', $setting->website) }}" placeholder="https://example.com">
                </div>

                <div class="md:col-span-2">
                    <label for="address"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                    <textarea id="address" name="address" rows="3"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2.5 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors">{{ old('address', $setting->address) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="site_description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site Description</label>
                    <textarea id="site_description" name="site_description" rows="3"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-2.5 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors">{{ old('site_description', $setting->site_description) }}</textarea>
                </div>






                {{-- Logo Settings --}}
                <div class="md:col-span-2 mt-4">
                    <h3
                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Branding & Logos</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Favicon --}}
                        <div
                            class="relative group rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-5 transition-all hover:shadow-md hover:border-indigo-300 dark:hover:border-indigo-500">
                            <label for="favicon"
                                class="block text-sm text-center font-medium text-gray-700 dark:text-gray-200 mb-3">Favicon</label>

                            <div
                                class="bg-white dark:bg-gray-900 rounded-lg border border-dashed border-gray-300 dark:border-gray-600 p-4 h-32 flex items-center justify-center mb-4 relative overflow-hidden transition-colors">
                                <img id="favicon_preview" src="{{ $setting->favicon_url }}"
                                    class="h-12 w-12 object-contain group-hover:scale-110 transition-transform duration-300"
                                    alt="Favicon">
                            </div>

                            <input id="favicon" name="favicon" type="file"
                                onchange="previewImage(this, 'favicon_preview')"
                                class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 dark:file:bg-gray-700 dark:file:text-gray-200 hover:file:bg-indigo-100 dark:hover:file:bg-gray-600 cursor-pointer transition-colors"
                                accept=".ico,.png,.jpg,.jpeg">

                            <p class="mt-2 text-xs text-center text-gray-500 dark:text-gray-400">ICO, PNG, JPG (Max 1MB)
                            </p>
                            @error('favicon')
                                <p class="mt-1 text-sm text-center text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Light Mode Logo --}}
                        <div
                            class="relative group rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-5 transition-all hover:shadow-md hover:border-indigo-300 dark:hover:border-indigo-500">
                            <label for="light_logo"
                                class="block text-sm text-center font-medium text-gray-700 dark:text-gray-200 mb-3">Light
                                Mode Logo</label>

                            <!-- Light Logo-এর জন্য সব সময় হালকা ব্যাকগ্রাউন্ড রাখা হয়েছে যেন ডার্ক টেক্সট বোঝা যায় -->
                            <div
                                class="bg-gray-100 rounded-lg border border-dashed border-gray-300 dark:border-gray-600 p-4 h-32 flex items-center justify-center mb-4 relative overflow-hidden transition-colors">
                                <img id="light_logo_preview" src="{{ $setting->light_logo_url }}"
                                    class="max-h-14 w-auto object-contain group-hover:scale-105 transition-transform duration-300 drop-shadow-sm"
                                    alt="Light Mode Logo">
                            </div>

                            <input id="light_logo" name="light_logo" type="file"
                                onchange="previewImage(this, 'light_logo_preview')"
                                class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 dark:file:bg-gray-700 dark:file:text-gray-200 hover:file:bg-indigo-100 dark:hover:file:bg-gray-600 cursor-pointer transition-colors"
                                accept=".png,.jpg,.jpeg,.webp">

                            <p class="mt-2 text-xs text-center text-gray-500 dark:text-gray-400">PNG, JPG, WebP (Max
                                2MB)</p>
                            @error('light_logo')
                                <p class="mt-1 text-sm text-center text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dark Mode Logo --}}
                        <div
                            class="relative group rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-5 transition-all hover:shadow-md hover:border-indigo-300 dark:hover:border-indigo-500">
                            <label for="dark_logo"
                                class="block text-sm text-center font-medium text-gray-700 dark:text-gray-200 mb-3">Dark
                                Mode Logo</label>

                            <!-- Dark Logo-এর জন্য সব সময় গাঢ় ব্যাকগ্রাউন্ড রাখা হয়েছে যেন লাইট টেক্সট বোঝা যায় -->
                            <div
                                class="bg-gray-900 rounded-lg border border-dashed border-gray-600 p-4 h-32 flex items-center justify-center mb-4 relative overflow-hidden transition-colors">
                                <img id="dark_logo_preview" src="{{ $setting->dark_logo_url }}"
                                    class="max-h-14 w-auto object-contain group-hover:scale-105 transition-transform duration-300 drop-shadow-md"
                                    alt="Dark Mode Logo">
                            </div>

                            <input id="dark_logo" name="dark_logo" type="file"
                                onchange="previewImage(this, 'dark_logo_preview')"
                                class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 dark:file:bg-gray-700 dark:file:text-gray-200 hover:file:bg-indigo-100 dark:hover:file:bg-gray-600 cursor-pointer transition-colors"
                                accept=".png,.jpg,.jpeg,.webp">

                            <p class="mt-2 text-xs text-center text-gray-500 dark:text-gray-400">PNG, JPG, WebP (Max
                                2MB)</p>
                            @error('dark_logo')
                                <p class="mt-1 text-sm text-center text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            <!-- Submit Button -->
            <div class="mt-10 flex justify-end items-center pt-5 border-t border-gray-200 dark:border-gray-700">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Save Settings
                </button>
            </div>

        </form>
    </div>

    <!-- Image Preview JavaScript -->
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
