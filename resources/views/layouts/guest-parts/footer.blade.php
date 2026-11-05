<footer class="mt-auto border-t border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
    <div class="w-full px-4 py-12 sm:px-6 lg:px-10 xl:px-12 2xl:px-16">

        <div class="grid gap-10 md:grid-cols-3 xl:gap-16">
            <div>

                <!-- Logo -->
                <a href="{{ route('home') }}" class="inline-flex items-center">
                    <img src="{{ $siteSettings?->dark_logo_url ?? asset('assets/images/logo/logo-dark.png') }}"
                        class="h-7 w-auto xl:h-8 dark:hidden" alt="Logo">
                    <img src="{{ $siteSettings?->light_logo_url ?? asset('assets/images/logo/logo-light.png') }}"
                        class="hidden h-7 w-auto xl:h-8 dark:block" alt="Logo">
                </a>

                <p class="mt-4 max-w-md text-sm leading-relaxed text-gray-600 dark:text-gray-400 xl:text-base">
                    {{ $siteSettings?->site_description
                        ? $siteSettings->site_description
                        : 'A comprehensive platform designed to streamline school administration, academics, and communication.' }}
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold xl:text-base">Quick links</h3>
                <ul class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-400 xl:mt-5 xl:space-y-4 xl:text-base">
                    <li><a href="#about"
                            class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">About</a></li>
                    <li><a href="#experience"
                            class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">Experience</a>
                    </li>
                    <li><a href="#contact"
                            class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">Contact</a>
                    </li>
                    <li><a href="{{ auth()->check() ? app(\App\Services\Access\AuthenticationDestination::class)->url(auth()->user()) : route('dashboard') }}"
                            class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">{{ auth()->check() && ! auth()->user()->isSuperAdmin() ? 'My account' : 'Admin Dashboard' }}</a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold xl:text-base">Contact</h3>
                <ul class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-400 xl:mt-5 xl:space-y-4 xl:text-base">
                    <li>
                        <a href="mailto:{{ $siteSettings?->email ? $siteSettings->email : 'liakatbiswas@gmail.com' }}"
                            class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">
                            {{ $siteSettings?->email ? $siteSettings->email : 'liakatbiswas@gmail.com' }}
                        </a>
                    </li>
                    <li>
                        <a href="tel:{{ $siteSettings?->phone ? $siteSettings->phone : '01571-719052' }}"
                            class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">
                            {{ $siteSettings?->phone ? $siteSettings->phone : '01571-719052' }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-10 border-t border-gray-200 pt-6 text-center text-xs text-gray-500 dark:border-gray-800 sm:text-left xl:mt-12 xl:pt-8 xl:text-sm">

            <p>
                &copy; {{ date('Y') }}
                {{ $siteSettings?->site_title ?: 'Name of Institution' }}.
                All Rights Reserved.
            </p>

            <p>{{ $siteSettings?->address ? $siteSettings->address : 'Mymensingh Sadar' }}</p>

        </div>

    </div>
</footer>
