<x-app-layout title="NGHS || Dashboard">
    @php
        $user = auth()->user();
        $twoFactorEnabled = $user->hasEnabledTwoFactorAuthentication();
    @endphp
    <div class="space-y-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="app-muted mb-1 text-xs font-medium uppercase tracking-widest">Workspace overview</p>
                <h1 class="text-2xl font-semibold tracking-tight sm:text-3xl">Dashboard</h1>
                <p class="app-muted mt-2 text-sm">Welcome back, {{ $user->name }}.</p>
            </div>
            <div class="app-panel flex items-center gap-2 rounded-xl px-4 py-2 text-sm">
                <i class="mgc_calendar_line app-muted text-lg" aria-hidden="true"></i>
                {{ now()->format('d M Y') }}
            </div>
        </div>

        <section class="app-panel grid overflow-hidden lg:grid-cols-3" aria-labelledby="workspace-heading">
            <div class="p-6 sm:p-8 lg:col-span-2">
                <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-200">
                    <i class="mgc_building_2_line" aria-hidden="true"></i>School administration
                </span>
                <h2 id="workspace-heading" class="mt-5 text-2xl font-semibold tracking-tight sm:text-3xl">{{ $siteSettings?->site_title ?: 'Your school workspace' }}</h2>
                <p class="app-muted mt-3 max-w-xl text-sm leading-7">Manage your school identity, keep contact details up to date, and move between your website and administration workspace.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    @can('view', App\Models\SiteSetting::class)
                        <a href="{{ route('settings.edit') }}" class="btn-primary">
                            <i class="mgc_settings_3_line text-lg" aria-hidden="true"></i>Site settings
                        </a>
                    @endcan
                    <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn-secondary">
                        View website<i class="mgc_external_link_line" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="border-t app-divider bg-indigo-50/50 p-6 dark:bg-indigo-500/5 sm:p-8 lg:border-t-0 lg:border-s">
                <div class="profile-avatar mb-4">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <p class="app-muted text-xs font-medium uppercase tracking-widest">Signed in as</p>
                <h3 class="mt-2 break-words text-lg font-semibold">{{ $user->name }}</h3>
                <p class="app-muted mt-1 break-all text-sm">{{ $user->email }}</p>
                <div class="mt-4 flex flex-wrap gap-2">
                    @forelse ($user->getRoleNames() as $role)
                        <span class="rounded-lg border app-divider px-2.5 py-1 text-xs font-medium">{{ str($role)->replace('-', ' ')->title() }}</span>
                    @empty
                        <span class="app-muted text-xs">No role assigned</span>
                    @endforelse
                </div>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-3">
            <section class="space-y-4 xl:col-span-2" aria-labelledby="quick-actions-heading">
                <div>
                    <h2 id="quick-actions-heading" class="text-lg font-semibold">Quick actions</h2>
                    <p class="app-muted text-sm">Your everyday workspace shortcuts.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    @can('view', App\Models\SiteSetting::class)
                        <a href="{{ route('settings.edit') }}" class="action-card">
                            <span class="profile-avatar shrink-0"><i class="mgc_settings_3_line text-xl" aria-hidden="true"></i></span>
                            <div><h3 class="font-semibold">Site settings</h3><p class="app-muted mt-1 text-sm">Update school details, contact information and logos.</p><span class="mt-4 inline-block text-xs font-semibold text-indigo-600 dark:text-indigo-300">Open settings &rarr;</span></div>
                        </a>
                    @endcan
                    <a href="{{ route('home') }}" target="_blank" rel="noopener" class="action-card">
                        <span class="profile-avatar shrink-0"><i class="mgc_world_2_line text-xl" aria-hidden="true"></i></span>
                        <div><h3 class="font-semibold">School website</h3><p class="app-muted mt-1 text-sm">See the public website in a new tab.</p><span class="mt-4 inline-block text-xs font-semibold text-indigo-600 dark:text-indigo-300">View website &rarr;</span></div>
                    </a>
                </div>
                <section class="app-panel" aria-labelledby="school-details-heading">
                    <div class="app-panel-heading"><h2 id="school-details-heading" class="font-semibold">School details</h2></div>
                    <dl class="grid gap-5 p-6 sm:grid-cols-2">
                        @foreach (['Email address' => $siteSettings?->email, 'Phone number' => $siteSettings?->phone, 'Website' => $siteSettings?->website, 'Address' => $siteSettings?->address] as $label => $value)
                            <div><dt class="app-muted text-xs">{{ $label }}</dt><dd class="mt-1 break-words text-sm font-medium">{{ $value ?: 'Not set' }}</dd></div>
                        @endforeach
                    </dl>
                </section>
            </section>

            <section class="app-panel h-fit p-6" aria-labelledby="security-heading">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <span class="profile-avatar"><i class="mgc_safety_certificate_line text-xl" aria-hidden="true"></i></span>
                    <span @class(['rounded-full px-3 py-1 text-xs font-medium', 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200' => $twoFactorEnabled, 'bg-amber-50 text-amber-800 dark:bg-amber-500/15 dark:text-amber-200' => ! $twoFactorEnabled])>
                        {{ $twoFactorEnabled ? '2FA enabled' : '2FA not enabled' }}
                    </span>
                </div>
                <h2 id="security-heading" class="text-lg font-semibold">Account security</h2>
                <p class="app-muted mt-2 text-sm leading-7">{{ $twoFactorEnabled ? 'Your account uses a second verification step when you sign in.' : 'Your account currently uses password authentication. Two-factor authentication has not been set up.' }}</p>
                <a href="{{ route('password.confirm') }}" class="btn-secondary mt-5 w-full"><i class="mgc_lock_line" aria-hidden="true"></i>Confirm password</a>
            </section>
        </div>
    </div>
</x-app-layout>
