<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_title',
        'site_subtitle',
        'site_tagline',
        'site_description',
        'favicon_path',
        'light_logo_path',
        'dark_logo_path',
        'phone',
        'email',
        'address',
        'website',
        'updated_by',
    ];

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getFaviconUrlAttribute(): string
    {
        return $this->publicAssetUrl($this->favicon_path, 'assets/images/logo/favicon.ico');
    }

    public function getLightLogoUrlAttribute(): string
    {
        return $this->publicAssetUrl($this->light_logo_path, 'assets/images/logo/logo-light.png');
    }

    public function getDarkLogoUrlAttribute(): string
    {
        return $this->publicAssetUrl($this->dark_logo_path, 'assets/images/logo/logo-dark.png');
    }

    protected function publicAssetUrl(?string $path, string $fallback): string
    {
        if (blank($path)) {
            return asset($fallback);
        }

        return Str::startsWith($path, 'site-settings/')
            ? Storage::disk('public')->url($path)
            : asset($path);
    }
}
