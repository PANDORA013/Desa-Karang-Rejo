<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Upload image to storage
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string
     */
    public static function upload($file, $directory = 'posts')
    {
        try {
            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $fullPath = trim($directory, '/') . '/' . $filename;
            
            // Ensure directory exists
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            // Store the file
            $path = $file->storeAs(
                $directory,
                $filename,
                'public'
            );
            
            if (!$path) {
                throw new \Exception('Gagal menyimpan file gambar ke storage.');
            }
            
            // Verify file exists
            if (!Storage::disk('public')->exists($fullPath)) {
                throw new \Exception('File gambar tidak ditemukan setelah upload.');
            }
            
            return $fullPath;
            
        } catch (\Exception $e) {
            \Log::error('ImageService - Upload Error: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Delete image from storage
     *
     * @param string $path
     * @return bool
     */
    public static function delete($path)
    {
        try {
            if (empty($path)) {
                return false;
            }
            
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->delete($path);
            }
            
            return false;
            
        } catch (\Exception $e) {
            \Log::error('ImageService - Delete Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get full URL for the image
     *
     * @param string|null $path
     * @param string $default
     * @return string
     */
    public static function url($path, $default = 'images/default-post.jpg')
    {
        if (empty($path)) {
            return asset($default);
        }
        
        return Storage::disk('public')->url($path);
    }
}
