<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Repositories\Settings\SiteSettingRepository;
use App\Repositories\Settings\SiteSettingRepositoryInterface;
use App\Services\Access\AccessSettingsService;
use App\Services\Settings\SiteSettingService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            SiteSettingRepositoryInterface::class,
            SiteSettingRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(fn (User $user): ?bool => $user->isSuperAdmin() ? true : null);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        View::composer(['layouts.app', 'layouts.guest', 'auth.login'], function ($view): void {
            $view->with('siteSettings', app(SiteSettingService::class)->getSettings());
            $view->with('registrationOpen', app(AccessSettingsService::class)->registrationIsOpen());
        });
    }
}
