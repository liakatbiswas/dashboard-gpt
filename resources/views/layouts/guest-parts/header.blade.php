<header x-data="headerNav" @keydown.escape.window="closeMobileMenu()"
    class="sticky top-0 z-50 w-full border-b border-gray-200/80 bg-white/80 backdrop-blur-md dark:border-gray-800/80 dark:bg-gray-900/80">

    <div class="flex h-16 w-full items-center justify-between gap-4 px-4 sm:px-6 lg:px-10 xl:px-12 2xl:px-16">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex shrink-0 items-center">
            <img x-cloak x-show="theme === 'light'"
                src="{{ $siteSettings?->dark_logo_url ?? asset('assets/images/logo/logo-dark.png') }}"
                class="h-7 w-auto" alt="Logo">
            <img x-cloak x-show="theme === 'dark'"
                src="{{ $siteSettings?->light_logo_url ?? asset('assets/images/logo/logo-light.png') }}"
                class="h-7 w-auto" alt="Logo">
        </a>

        <!-- Right side -->
        <div class="flex min-w-0 items-center gap-1 sm:gap-2">

            <!-- Theme Toggle -->
            <button type="button" @click="toggleTheme()"
                :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
                title="Toggle light/dark mode"
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-gray-600 transition-colors hover:bg-gray-100 hover:text-indigo-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-indigo-400">

                <!-- Sun (dark mode) -->
                <svg x-cloak x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <circle cx="12" cy="12" r="4" />
                    <path stroke-linecap="round"
                        d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" />
                </svg>

                <!-- Moon (light mode) -->
                <svg x-cloak x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.9 13A9 9 0 0 1 11 3.1 9 9 0 1 0 20.9 13Z" />
                </svg>
            </button>

            <!-- Desktop Navigation -->
            <nav class="hidden items-center gap-1 md:flex">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-indigo-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-indigo-400">
                    <i class="mgc_home_3_line text-lg" aria-hidden="true"></i>
                    <span>Home</span>
                </a>

                @guest
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-indigo-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-indigo-400">
                        <i class="mgc_enter_door_line text-lg" aria-hidden="true"></i>
                        <span>Login</span>
                    </a>

                    <a href="{{ route('register') }}"
                        class="ml-1 flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
                        <i class="mgc_user_add_line text-lg" aria-hidden="true"></i>
                        <span>Register</span>
                    </a>
                @endguest

                @auth
                    <a href="{{ route(auth()->user()->can('dashboard.view') ? 'dashboard' : 'account.pending') }}"
                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-indigo-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-indigo-400">
                        <i class="mgc_dashboard_3_line text-lg" aria-hidden="true"></i>
                        <span>{{ auth()->user()->can('dashboard.view') ? 'Dashboard' : 'My account' }}</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="ml-1 flex items-center gap-2 rounded-lg bg-rose-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-rose-700 cursor-pointer">
                            <i class="mgc_exit_line text-lg" aria-hidden="true"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                @endauth
            </nav>



            <!-- Mobile Menu Toggle -->
            <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" :aria-expanded="mobileMenuOpen.toString()"
                aria-controls="mobile-navigation" :aria-label="mobileMenuOpen ? 'Close menu' : 'Open menu'"
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-gray-600 transition-colors hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:text-gray-300 dark:hover:bg-gray-800 md:hidden">
                <svg x-cloak x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-cloak x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <nav id="mobile-navigation" x-cloak x-show="mobileMenuOpen" x-transition @click.outside="closeMobileMenu()"
        class="absolute inset-x-0 top-full border-b border-gray-200 bg-white shadow-lg dark:border-gray-800 dark:bg-gray-900 md:hidden">
        <div class="flex w-full flex-col gap-1 px-4 py-4 sm:px-6">
            <a href="{{ route('home') }}" @click="closeMobileMenu()"
                class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                <i class="mgc_home_3_line text-lg" aria-hidden="true"></i>
                <span>Home</span>
            </a>

            @guest
                <a href="{{ route('login') }}" @click="closeMobileMenu()"
                    class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                    <i class="mgc_enter_door_line text-lg" aria-hidden="true"></i>
                    <span>Login</span>
                </a>

                <a href="{{ route('register') }}" @click="closeMobileMenu()"
                    class="mt-2 flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-3 py-3 text-sm font-medium text-white hover:bg-indigo-700">
                    <i class="mgc_user_add_line text-lg" aria-hidden="true"></i>
                    <span>Register</span>
                </a>
            @endguest

            @auth
                <a href="{{ route(auth()->user()->can('dashboard.view') ? 'dashboard' : 'account.pending') }}" @click="closeMobileMenu()"
                    class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                    <i class="mgc_dashboard_3_line text-lg" aria-hidden="true"></i>
                    <span>{{ auth()->user()->can('dashboard.view') ? 'Dashboard' : 'My account' }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-rose-600 px-3 py-3 text-sm font-medium text-white hover:bg-rose-700">
                        <i class="mgc_exit_line text-lg" aria-hidden="true"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @endauth
        </div>
    </nav>
</header>
