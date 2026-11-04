<?php

namespace App\Services\Settings;

use App\Models\SiteSetting;
use App\Repositories\Settings\SiteSettingRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class SiteSettingService
{
    protected const CACHE_KEY = 'site_settings:v2';

    public function __construct(
        protected SiteSettingRepositoryInterface $repository
    ) {}

    public function getSettings(): SiteSetting
    {
        $attributes = Cache::rememberForever(
            self::CACHE_KEY,
            fn (): array => $this->repository->getSettings()->getAttributes(),
        );

        return SiteSetting::query()->hydrate([$attributes])->first() ?? new SiteSetting;
    }

    public function updateSettings(array $data): void
    {
        $settings = $this->repository->getSettings();

        $newPaths = [];
        $oldPaths = [];

        try {
            foreach (['favicon' => 'favicon_path', 'light_logo' => 'light_logo_path', 'dark_logo' => 'dark_logo_path'] as $field => $column) {
                if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                    $oldPaths[] = $settings->{$column};
                    $newPath = $this->storeFile($data[$field]);
                    $newPaths[] = $newPath;
                    $data[$column] = $newPath;
                    unset($data[$field]);
                }
            }

            $data['updated_by'] = Auth::id();

            $this->repository->update($data);
        } catch (Throwable $exception) {
            foreach ($newPaths as $newPath) {
                try {
                    Storage::disk('public')->delete($newPath);
                } catch (Throwable $cleanupException) {
                    report($cleanupException);
                }
            }

            throw $exception;
        }

        Cache::forget(self::CACHE_KEY);

        foreach (array_filter($oldPaths) as $oldPath) {
            try {
                Storage::disk('public')->delete($oldPath);
            } catch (Throwable $exception) {
                report($exception);
            }
        }
    }

    protected function storeFile(UploadedFile $file): string
    {
        $path = $file->store('site-settings', 'public');

        if (! is_string($path)) {
            throw new RuntimeException('The uploaded settings file could not be stored.');
        }

        return $path;
    }
}
