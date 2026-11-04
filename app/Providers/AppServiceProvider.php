<?php

namespace App\Providers;

use App\Repositories\Settings\SiteSettingRepository;
use App\Repositories\Settings\SiteSettingRepositoryInterface;
use App\Services\Settings\SiteSettingService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer(['layouts.app', 'layouts.guest'], function ($view): void {
            $view->with('siteSettings', app(SiteSettingService::class)->getSettings());
        });
    }
}
