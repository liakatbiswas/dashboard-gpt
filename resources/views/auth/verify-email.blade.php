<x-guest-layout title="NGHS || Verify Email">


    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">

            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 text-center">

                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
                    Verify Your Email
                </h2>

                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    Thanks for signing up! Before getting started, please verify your email address
                    by clicking the link we just emailed to you.
                </p>

                <!-- Success Message -->
                @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-green-600 text-sm">
                    A new verification link has been sent to your email address.
                </div>
                @endif

                <!-- Resend Verification -->
                <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                    @csrf
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition">
                        Resend Verification Email
                    </button>
                </form>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white py-2 rounded-lg transition">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>

</x-guest-layout>