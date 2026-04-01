<?php

use Illuminate\Support\Facades\Schema;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'My Portfolio');
        $this->migrator->add('general.site_description', 'Portfolio Website');
        $this->migrator->add('general.site_logo', null);
        $this->migrator->add('general.site_favicon', null);

        $this->migrator->add('general.primary_color', '#3b82f6'); // Blue-500
        $this->migrator->add('general.secondary_color', '#8b5cf6'); // Violet-500

        $this->migrator->add('general.dev_name', 'Nama Developer');
        $this->migrator->add('general.dev_title', 'Web Developer');
        $this->migrator->add('general.dev_bio', 'Deskripsi singkat tentang diri anda...');
        $this->migrator->add('general.dev_avatar', null);

        $this->migrator->add('general.email', 'email@example.com');
        $this->migrator->add('general.phone', null);
        $this->migrator->add('general.social_links', []);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
