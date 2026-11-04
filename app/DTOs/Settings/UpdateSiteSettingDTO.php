<?php

namespace App\DTOs\Settings;

final readonly class UpdateSiteSettingDTO
{
    public function __construct(
        public string $siteTitle,
        public ?string $siteSubtitle,
        public ?string $siteTagline,
        public ?string $siteDescription,
        public ?string $phone,
        public ?string $email,
        public ?string $address,
        public ?string $website,
        public array $files = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            siteTitle: $data['site_title'],
            siteSubtitle: $data['site_subtitle'] ?? null,
            siteTagline: $data['site_tagline'] ?? null,
            siteDescription: $data['site_description'] ?? null,
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? null,
            address: $data['address'] ?? null,
            website: $data['website'] ?? null,
            files: array_intersect_key(
                $data,
                array_flip(['favicon', 'light_logo', 'dark_logo'])
            ),
        );
    }

    public function toArray(): array
    {
        return [
            'site_title' => $this->siteTitle,
            'site_subtitle' => $this->siteSubtitle,
            'site_tagline' => $this->siteTagline,
            'site_description' => $this->siteDescription,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'website' => $this->website,
        ];
    }
}
