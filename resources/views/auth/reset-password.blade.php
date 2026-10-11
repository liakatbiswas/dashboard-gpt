<x-guest-layout title="NGHS || Reset Password">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">

            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">

                <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-4">
                    Reset Password
                </h2>

                <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                    Enter your new password below.
                </p>

                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf

                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email', $request->email) }}" autofocus class="w-full px-4 py-2 border rounded-lg 
                            bg-gray-50 dark:bg-gray-700 
                            text-gray-800 dark:text-white
                            border-gray-300 dark:border-gray-600
                            focus:ring-2 focus:ring-indigo-500 outline-none">
                        @error('email')
                        <span class="mb-4 text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">
                            New Password
                        </label>
                        <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg 
                            bg-gray-50 dark:bg-gray-700 
                            text-gray-800 dark:text-white
                            border-gray-300 dark:border-gray-600
                            focus:ring-2 focus:ring-indigo-500 outline-none">
                        @error('password')
                        <span class="mb-4 text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">
                            Confirm Password
                        </label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg 
                            bg-gray-50 dark:bg-gray-700 
                            text-gray-800 dark:text-white
                            border-gray-300 dark:border-gray-600
                            focus:ring-2 focus:ring-indigo-500 outline-none">
                        @error('password_confirmation')
                        <span class="mb-4 text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition cursor-pointer">
                        Reset Password
                    </button>
                </form>

                <!-- Back to Login -->
                <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    Back to
                    <a href="{{ route('login') }}" class="text-indigo-500 hover:underline">
                        Login
                    </a>
                </p>

            </div>
        </div>
    </div>

</x-guest-layout>