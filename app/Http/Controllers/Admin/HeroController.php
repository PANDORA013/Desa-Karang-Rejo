<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        return view('admin.hero.index');
    }
    
    public function updateBackground(Request $request)
    {
        $request->validate([
            'background_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hapus gambar lama jika ada
        if (Storage::disk('public')->exists('images/hero-bg.jpg')) {
            Storage::disk('public')->delete('images/hero-bg.jpg');
        }

        // Simpan gambar baru
        $path = $request->file('background_image')->storeAs('images', 'hero-bg.jpg', 'public');

        return response()->json([
            'success' => true,
            'message' => 'Background berhasil diupdate',
            'path' => Storage::url($path)
        ]);
    }
}
