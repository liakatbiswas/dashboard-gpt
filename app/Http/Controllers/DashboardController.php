<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Access\AccessSettingsService;
use App\Services\Settings\SiteSettingService;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SiteSettingService $settings, AccessSettingsService $access): View
    {
        return view('dashboard', [
            'siteSettings' => $settings->getSettings(),
            'roleCount' => Role::query()->where('guard_name', 'web')->count(),
            'permissionCount' => Permission::query()->where('guard_name', 'web')->count(),
            'studentCount' => User::query()->whereHas('roles', fn ($query) => $query->where('name', config('access.student_role'))->where('guard_name', 'web'))->count(),
            'registrationOpen' => $access->registrationIsOpen(),
        ]);
    }
}
