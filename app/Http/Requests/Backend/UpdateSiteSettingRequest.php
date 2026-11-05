<?php

namespace App\Http\Requests\Backend;

use App\Models\SiteSetting;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', SiteSetting::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Basic Settings Validation
            'site_title' => ['required', 'string', 'max:150'],
            'site_subtitle' => ['nullable', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'address' => ['nullable', 'string'],
            'site_description' => ['nullable', 'string'],

            // Image Settings Validation (Size in Kilobytes)
            'favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg', 'max:1024'], // Max 1 MB
            'light_logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'], // Max 2 MB
            'dark_logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'], // Max 2 MB
        ];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'favicon.max' => 'Favicon-এর সাইজ ১ মেগাবাইটের বেশি হতে পারবে না।',
            'favicon.mimes' => 'Favicon অবশ্যই ico, png, jpg বা jpeg ফরম্যাটের হতে হবে।',

            'light_logo.max' => 'Light Logo-এর সাইজ ২ মেগাবাইটের বেশি হতে পারবে না।',
            'light_logo.mimes' => 'Light Logo অবশ্যই png, jpg, jpeg বা webp ফরম্যাটের হতে হবে।',

            'dark_logo.max' => 'Dark Logo-এর সাইজ ২ মেগাবাইটের বেশি হতে পারবে না।',
            'dark_logo.mimes' => 'Dark Logo অবশ্যই png, jpg, jpeg বা webp ফরম্যাটের হতে হবে।',
        ];
    }
}
