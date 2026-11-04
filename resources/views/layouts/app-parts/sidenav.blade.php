<div class="app-menu">

    <!-- Sidenav Brand Logo -->
    <a href="{{ route('dashboard') }}" class="logo-box">
        <!-- Light Brand Logo -->
        <div class="logo-light">
            <img src="{{ $siteSettings?->light_logo_url ?? asset('assets/images/logo/logo-light.png') }}" class="logo-lg h-6" alt="Light logo">
            <img src="assets/images/logo-sm.png" class="logo-sm" alt="Small logo">
        </div>

        <!-- Dark Brand Logo -->
        <div class="logo-dark">
            <img src="{{ $siteSettings?->dark_logo_url ?? asset('assets/images/logo/logo-dark.png') }}" class="logo-lg h-6" alt="Dark logo">
            <img src="assets/images/logo-sm.png" class="logo-sm" alt="Small logo">
        </div>
    </a>

    <!-- Sidenav Menu Toggle Button -->
    <button id="button-hover-toggle" class="absolute top-5 inset-e-2 rounded-full p-1.5">
        <span class="sr-only">Menu Toggle Button</span>
        <i class="mgc_round_line text-xl"></i>
    </button>

    <!--- Menu -->
    <div class="srcollbar" data-simplebar>
        <ul class="menu" data-fc-type="accordion">
            <li class="menu-title">Menu</li>

            @can('dashboard.view')
                <li class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <span class="menu-icon"><i class="mgc_home_3_line"></i></span>
                    <span class="menu-text"> Dashboard </span>
                </a>
                </li>
            @endcan

            @can('view', App\Models\SiteSetting::class)
                <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mgc_building_2_line"></i></span>
                    <span class="menu-text"> Settings </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{ route('settings.edit') }}" class="menu-link">
                            <span class="menu-text">Site Settings</span>
                        </a>
                    </li>
                </ul>
                </li>
            @endcan

        </ul>

    </div>
</div>
