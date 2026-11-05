<aside class="app-menu" aria-label="Main navigation">
    <a href="{{ route('dashboard') }}" class="logo-box" aria-label="Dashboard home">
        <div class="logo-light">
            <img src="{{ $siteSettings?->light_logo_url ?? asset('assets/images/logo/logo-light.png') }}" class="logo-lg h-7 max-w-44 object-contain" alt="{{ $siteSettings?->site_title ?: 'School' }}">
            <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="School">
        </div>
        <div class="logo-dark">
            <img src="{{ $siteSettings?->dark_logo_url ?? asset('assets/images/logo/logo-dark.png') }}" class="logo-lg h-7 max-w-44 object-contain" alt="{{ $siteSettings?->site_title ?: 'School' }}">
            <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="School">
        </div>
    </a>

    <button id="button-hover-toggle" type="button" class="absolute top-6 end-2 rounded-full p-1.5" aria-label="Toggle sidebar size">
        <i class="mgc_round_line text-xl" aria-hidden="true"></i>
    </button>

    <div data-simplebar>
        <ul class="menu">
            <li class="menu-title">Workspace</li>
            @can('dashboard.view')
                <li class="menu-item">
                    <a href="{{ route('dashboard') }}" @class(['menu-link', 'active' => request()->routeIs('dashboard')])
                        @if (request()->routeIs('dashboard')) aria-current="page" @endif>
                        <span class="menu-icon"><i class="mgc_home_3_line" aria-hidden="true"></i></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
            @endcan
            @can('view', App\Models\SiteSetting::class)
                <li class="menu-item">
                    <a href="{{ route('settings.edit') }}" @class(['menu-link', 'active' => request()->routeIs('settings.*')])
                        @if (request()->routeIs('settings.*')) aria-current="page" @endif>
                        <span class="menu-icon"><i class="mgc_settings_3_line" aria-hidden="true"></i></span>
                        <span class="menu-text">Site Settings</span>
                    </a>
                </li>
            @endcan
            @if (auth()->user()->isSuperAdmin())
                <li class="menu-title mt-5">Access management</li>
                @foreach ([
                    ['roles.index', 'roles.*', 'Roles', 'mgc_group_line'],
                    ['permissions.index', 'permissions.*', 'Permissions', 'mgc_key_2_line'],
                    ['registration.edit', 'registration.*', 'Student Registration', 'mgc_user_add_line'],
                ] as [$target, $active, $text, $icon])
                    <li class="menu-item">
                        <a href="{{ route($target) }}" @class(['menu-link', 'active' => request()->routeIs($active)])
                            @if (request()->routeIs($active)) aria-current="page" @endif>
                            <span class="menu-icon"><i class="{{ $icon }}" aria-hidden="true"></i></span>
                            <span class="menu-text">{{ $text }}</span>
                        </a>
                    </li>
                @endforeach
            @endif
            <li class="menu-title mt-5">Quick links</li>
            <li class="menu-item">
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="menu-link">
                    <span class="menu-icon"><i class="mgc_external_link_line" aria-hidden="true"></i></span>
                    <span class="menu-text">View website</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
