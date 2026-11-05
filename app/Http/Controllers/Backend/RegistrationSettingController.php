<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UpdateRegistrationSettingRequest;
use App\Services\Access\AccessSettingsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegistrationSettingController extends Controller
{
    public function edit(AccessSettingsService $settings): View
    {
        return view('backend.access.registration', ['accessSetting' => $settings->get()->load('updatedBy')]);
    }

    public function update(UpdateRegistrationSettingRequest $request, AccessSettingsService $settings): RedirectResponse
    {
        $enabled = $request->boolean('student_registration_enabled');
        $settings->updateRegistration($enabled, $request->user());

        return redirect()->route('registration.edit')
            ->with('success', $enabled ? 'Student registration is now open.' : 'Student registration is now closed.');
    }
}
