<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share settings to all views
        $defaultSettings = [
            'site_name' => 'Desa Karangrejo',
            'site_description' => 'Website Resmi Desa Karangrejo',
            'site_keywords' => 'desa, karangrejo, pemerintahan, layanan',
            'contact_email' => 'info@desakarangrejo.id',
            'contact_phone' => '(0322) 123456',
            'contact_address' => 'Jl. Raya Karangrejo No. 123, Kecamatan Sukodadi, Kabupaten Lamongan, Jawa Timur',
            'facebook_url' => '',
            'instagram_url' => '',
            'youtube_url' => '',
            'whatsapp_number' => '',
            'office_hours' => 'Senin - Jumat: 08:00 - 16:00 WIB',
            'google_analytics_id' => '',
            'site_logo' => ''
        ];
        $settings = [];
        foreach ($defaultSettings as $key => $default) {
            $settings[$key] = \Cache::get("setting_{$key}", $default);
        }
        view()->share('settings', $settings);
    }
}
