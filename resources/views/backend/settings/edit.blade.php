<x-app-layout title="NGHS || Site Settings">
    <div class="space-y-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="app-muted mb-1 text-xs font-medium uppercase tracking-widest">Workspace / Settings</p>
                <h1 class="text-2xl font-semibold tracking-tight sm:text-3xl">Site Settings</h1>
                <p class="app-muted mt-2 text-sm">Manage your school identity, contact information and logos.</p>
            </div>
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn-secondary">
                <i class="mgc_external_link_line" aria-hidden="true"></i>View website
            </a>
        </div>

        @if (session('success'))
            <div class="notice-success" role="status"><i class="mgc_check_circle_line me-2" aria-hidden="true"></i>{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="notice-error" role="alert">Please correct the highlighted fields below, then save again.</div>
        @endif
        @cannot('update', App\Models\SiteSetting::class)
            <div class="app-panel app-muted px-5 py-4 text-sm">You have permission to view these settings. Editing requires settings access.</div>
        @endcannot

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="app-panel" aria-labelledby="school-identity-heading">
                <div class="app-panel-heading">
                    <h2 id="school-identity-heading" class="font-semibold">School identity</h2>
                    <p class="app-muted mt-1 text-sm">The name and description displayed on your website.</p>
                </div>
                <fieldset @disabled(! auth()->user()->can('update', App\Models\SiteSetting::class)) class="grid min-w-0 gap-5 p-5 sm:grid-cols-2 sm:p-6">
                    <legend class="sr-only">School identity fields</legend>
                    <x-form.input name="site_title" label="Site title" :value="$setting->site_title" required maxlength="150" autocomplete="organization" />
                    <x-form.input name="site_subtitle" label="Site subtitle" :value="$setting->site_subtitle" maxlength="255" />
                    <div class="sm:col-span-2"><x-form.input name="site_tagline" label="Tagline" :value="$setting->site_tagline" maxlength="255" /></div>
                    <div class="sm:col-span-2"><x-form.textarea name="site_description" label="Site description" :value="$setting->site_description" rows="4" /></div>
                </fieldset>
            </section>

            <section class="app-panel" aria-labelledby="contact-heading">
                <div class="app-panel-heading">
                    <h2 id="contact-heading" class="font-semibold">Contact information</h2>
                    <p class="app-muted mt-1 text-sm">Help visitors reach your school.</p>
                </div>
                <fieldset @disabled(! auth()->user()->can('update', App\Models\SiteSetting::class)) class="grid min-w-0 gap-5 p-5 sm:grid-cols-2 sm:p-6">
                    <legend class="sr-only">Contact information fields</legend>
                    <x-form.input name="email" label="Email address" type="email" :value="$setting->email" maxlength="255" autocomplete="email" placeholder="school@example.com" />
                    <x-form.input name="phone" label="Phone number" type="tel" :value="$setting->phone" maxlength="30" autocomplete="tel" />
                    <div class="sm:col-span-2"><x-form.input name="website" label="Website URL" type="url" :value="$setting->website" maxlength="255" placeholder="https://example.com" /></div>
                    <div class="sm:col-span-2"><x-form.textarea name="address" label="Address" :value="$setting->address" autocomplete="street-address" /></div>
                </fieldset>
            </section>

            <section class="app-panel" aria-labelledby="branding-heading">
                <div class="app-panel-heading">
                    <h2 id="branding-heading" class="font-semibold">Branding &amp; logos</h2>
                    <p class="app-muted mt-1 text-sm">Preview your existing images or upload replacements.</p>
                </div>
                <div class="p-5 sm:p-6">
                    @cannot('settings.upload_media')
                        <p class="app-muted mb-5 text-sm">Uploading images requires the media upload permission.</p>
                    @endcannot
                    <div class="grid gap-5 md:grid-cols-3">
                        @foreach ([
                            ['favicon', 'Favicon', $setting->favicon_url, '.ico,.png,.jpg,.jpeg', 'ICO, PNG or JPG · Up to 1 MB', 'bg-slate-100 border-slate-200', 'h-12 w-12'],
                            ['light_logo', 'Logo on dark backgrounds', $setting->light_logo_url, '.png,.jpg,.jpeg,.webp', 'PNG, JPG or WebP · Up to 2 MB', 'bg-slate-900 border-slate-700', 'max-h-16 max-w-full'],
                            ['dark_logo', 'Logo on light backgrounds', $setting->dark_logo_url, '.png,.jpg,.jpeg,.webp', 'PNG, JPG or WebP · Up to 2 MB', 'bg-slate-100 border-slate-200', 'max-h-16 max-w-full'],
                        ] as [$field, $label, $src, $accept, $hint, $background, $imageSize])
                            <div class="min-w-0 rounded-xl border app-divider p-4">
                                <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                <div class="my-4 flex h-32 items-center justify-center rounded-lg border border-dashed p-4 {{ $background }}">
                                    <img id="{{ $field }}_preview" src="{{ $src }}" alt="{{ $label }}" class="object-contain {{ $imageSize }}">
                                </div>
                                <input id="{{ $field }}" name="{{ $field }}" type="file" accept="{{ $accept }}"
                                    data-image-preview="{{ $field }}_preview" class="form-file"
                                    @disabled(! auth()->user()->can('update', App\Models\SiteSetting::class) || ! auth()->user()->can('settings.upload_media'))
                                    aria-invalid="{{ $errors->has($field) ? 'true' : 'false' }}"
                                    aria-describedby="{{ $field }}-hint{{ $errors->has($field) ? ' '.$field.'-error' : '' }}">
                                <p id="{{ $field }}-hint" class="field-hint">{{ $hint }}</p>
                                @error($field)<p id="{{ $field }}-error" class="field-error" role="alert">{{ $message }}</p>@enderror
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            @can('update', App\Models\SiteSetting::class)
                <div class="app-panel flex flex-wrap items-center justify-between gap-4 px-5 py-4 sm:px-6">
                    <p class="app-muted text-sm"><span class="text-rose-600 dark:text-rose-400">*</span> Required field</p>
                    <button type="submit" class="btn-primary w-full sm:w-auto">
                        <i class="mgc_check_line text-lg" aria-hidden="true"></i>Save settings
                    </button>
                </div>
            @endcan
        </form>
    </div>
</x-app-layout>
