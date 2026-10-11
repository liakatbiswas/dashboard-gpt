<x-guest-layout title="NGHS || Login">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">

            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">

                <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">
                    Login
                </h2>

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" autofocus class="w-full px-4 py-2 border rounded-lg 
                            bg-gray-50 dark:bg-gray-700 
                            text-gray-800 dark:text-white
                            border-gray-300 dark:border-gray-600
                            focus:ring-2 focus:ring-indigo-500 outline-none">
                        @error('email')
                        <span class="mb-4 text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">
                            Password
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

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center text-gray-600 dark:text-gray-300">
                            <input type="checkbox" name="remember" class="mr-2">
                            Remember me
                        </label>

                        <a href="{{ route('password.request') }}" class="text-indigo-500 hover:underline">
                            Forgot Password?
                        </a>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg cursor-pointer transition">
                        Login
                    </button>
                </form>

                <!-- Register -->
                <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-indigo-500 hover:underline">
                        Register
                    </a>
                </p>

            </div>
        </div>
    </div>

</x-guest-layout>