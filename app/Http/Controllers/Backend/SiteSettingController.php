<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UpdateSiteSettingRequest;
use App\Services\Settings\SiteSettingService;

class SiteSettingController extends Controller
{
    public function __construct(protected SiteSettingService $service) {}

    public function edit()
    {
        $setting = $this->service->getSettings();

        return view('backend.settings.edit', compact('setting'));
    }

    public function update(UpdateSiteSettingRequest $request)
    {
        $this->service->updateSettings($request->validated());

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
