<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    // Site Info
    public string $site_name;

    public ?string $site_description;

    public ?string $site_logo;

    public ?string $site_favicon;

    // Theme
    public string $primary_color;

    public string $secondary_color;

    // Personal Info
    public string $dev_name;

    public ?string $dev_title; // Job title e.g. "Fullstack Developer"

    public ?string $dev_bio;

    public ?string $dev_avatar;

    // Contact & Socials
    public ?string $email;

    public ?string $phone;

    public ?array $social_links; // Array untuk menyimpan link sosmed

    public static function group(): string
    {
        return 'general';
    }
}
