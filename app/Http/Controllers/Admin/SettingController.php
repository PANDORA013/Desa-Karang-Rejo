<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'site_keywords' => 'nullable|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'whatsapp_number' => 'nullable|string|max:20',
            'office_hours' => 'nullable|string|max:255',
            'google_analytics_id' => 'nullable|string|max:50',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:1024'
        ]);

        $settings = $request->except('site_logo');

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo
            $oldLogo = $this->getSetting('site_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $logo = $request->file('site_logo');
            $logoPath = $logo->store('settings', 'public');
            $settings['site_logo'] = $logoPath;
        }

        // Save settings to cache and/or database
        foreach ($settings as $key => $value) {
            $this->setSetting($key, $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:1024'
        ]);

        try {
            // Delete old logo
            $oldLogo = $this->getSetting('site_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $logo = $request->file('logo');
            $logoPath = $logo->store('settings', 'public');
            
            $this->setSetting('site_logo', $logoPath);

            return response()->json([
                'success' => true,
                'message' => 'Logo berhasil diupload.',
                'logo_url' => Storage::url($logoPath)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload logo.'
            ], 500);
        }
    }

    public function backup()
    {
        try {
            Artisan::call('backup:run');
            
            return response()->json([
                'success' => true,
                'message' => 'Backup berhasil dibuat.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat backup: ' . $e->getMessage()
            ], 500);
        }
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:zip,sql'
        ]);

        try {
            // Implementation for restore would go here
            // This is a placeholder for security reasons
            
            return response()->json([
                'success' => false,
                'message' => 'Fitur restore dalam pengembangan.'
            ], 501);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan restore: ' . $e->getMessage()
            ], 500);
        }
    }

    public function systemInfo()
    {
        $info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_version' => \DB::select('select version() as version')[0]->version ?? 'Unknown',
            'storage_used' => $this->getStorageUsed(),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size')
        ];

        return response()->json($info);
    }

    private function getSettings()
    {
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
            $settings[$key] = $this->getSetting($key, $default);
        }

        return $settings;
    }

    private function getSetting($key, $default = null)
    {
        return Cache::get("setting_{$key}", $default);
    }

    private function setSetting($key, $value)
    {
        Cache::forever("setting_{$key}", $value);
    }

    private function getStorageUsed()
    {
        $storagePath = storage_path('app/public');
        if (!is_dir($storagePath)) {
            return '0 MB';
        }

        $bytes = 0;
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($storagePath, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            $bytes += $file->getSize();
        }

        return $this->formatBytes($bytes);
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}