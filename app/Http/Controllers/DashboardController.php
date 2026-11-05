<?php

namespace App\Http\Controllers;

use App\Services\Settings\SiteSettingService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SiteSettingService $settings): View
    {
        return view('dashboard', ['siteSettings' => $settings->getSettings()]);
    }
}
