<header class="app-header flex items-center gap-3 px-4 sm:px-6 lg:px-8">
    <button id="button-toggle-menu" type="button" class="icon-button" aria-label="Toggle navigation">
        <i class="mgc_menu_line text-2xl" aria-hidden="true"></i>
    </button>

    <div class="min-w-0 me-auto">
        <p class="app-muted hidden text-xs sm:block">{{ $siteSettings?->site_title ?: 'School administration' }}</p>
        <p class="truncate text-sm font-semibold sm:text-base">{{ request()->routeIs('settings.*') ? 'Site Settings' : 'Dashboard' }}</p>
    </div>

    <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn-secondary hidden sm:inline-flex">
        <i class="mgc_external_link_line text-lg" aria-hidden="true"></i>
        View website
    </a>

    <button data-toggle="fullscreen" type="button" class="icon-button hidden md:inline-flex" aria-label="Toggle fullscreen">
        <i class="mgc_fullscreen_line text-xl" aria-hidden="true"></i>
    </button>

    <button id="theme-toggle" data-theme-toggle type="button" class="icon-button" aria-label="Switch to dark mode">
        <i class="mgc_moon_line text-xl dark:hidden" aria-hidden="true"></i>
        <i class="mgc_sun_line hidden text-xl dark:block" aria-hidden="true"></i>
    </button>

    <button data-fc-type="offcanvas" data-fc-target="theme-customization" type="button"
        class="icon-button" aria-label="Open appearance settings">
        <i class="mgc_settings_4_line text-xl" aria-hidden="true"></i>
    </button>

    <div class="relative border-s app-divider ps-3 sm:ps-4">
        <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button"
            class="flex items-center gap-2 rounded-xl p-1 text-start focus-visible:outline-2 focus-visible:outline-indigo-400"
            aria-label="Open account menu">
            <span class="profile-avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
            <span class="hidden max-w-36 min-w-0 lg:block">
                <span class="block truncate text-sm font-semibold">{{ auth()->user()->name }}</span>
                <span class="app-muted block text-xs">My account</span>
            </span>
            <i class="mgc_down_line app-muted hidden text-sm lg:block" aria-hidden="true"></i>
        </button>

        <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden w-64 rounded-xl p-2 opacity-0 z-50 mt-2 transition-opacity">
            <div class="border-b app-divider px-3 py-3 mb-1">
                <p class="truncate text-sm font-semibold">{{ auth()->user()->name }}</p>
                <p class="app-muted truncate text-xs">{{ auth()->user()->email }}</p>
            </div>
            <a href="{{ route('home') }}" class="profile-link"><i class="mgc_home_3_line" aria-hidden="true"></i>View website</a>
            <a href="{{ route('password.confirm') }}" class="profile-link"><i class="mgc_lock_line" aria-hidden="true"></i>Confirm password</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="profile-link">
                    <i class="mgc_exit_line" aria-hidden="true"></i>Log out
                </button>
            </form>
        </div>
    </div>
</header>
