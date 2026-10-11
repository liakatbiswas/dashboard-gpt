<x-guest-layout title="NGHS || Forgot Password">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">

            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">

                <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-4">
                    Forgot Password
                </h2>

                <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                    Enter your email and we’ll send you a password reset link.
                </p>

                <!-- Status Message -->
                @if (session('status'))
                <div class="mb-4 text-green-600 text-sm text-center">
                    {{ session('status') }}
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition cursor-pointer">
                        Send Reset Link
                    </button>
                </form>

                <!-- Back to Login -->
                <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    Remember your password?
                    <a href="{{ route('login') }}" class="text-indigo-500 hover:underline">
                        Login
                    </a>
                </p>

            </div>
        </div>
    </div>

</x-guest-layout>