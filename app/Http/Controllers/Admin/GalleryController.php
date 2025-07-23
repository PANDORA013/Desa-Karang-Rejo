<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = \App\Models\Gallery::orderByDesc('created_at')->paginate(15);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:foto,video',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
            'description' => 'nullable|string',
        ]);

        $gallery = new \App\Models\Gallery();
        $gallery->title = $request->title;
        $gallery->category = $request->category;
        $gallery->description = $request->description;
        $gallery->type = $request->category === 'video' ? 'video' : 'photo';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('galleries', $filename, 'public');
            $gallery->images = [$path];
        } else {
            $gallery->images = [];
        }

        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = \App\Models\Gallery::findOrFail($id);
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery = \App\Models\Gallery::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:foto,video',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
            'description' => 'nullable|string',
        ]);

        $gallery->title = $request->title;
        $gallery->category = $request->category;
        $gallery->description = $request->description;
        $gallery->type = $request->category === 'video' ? 'video' : 'photo';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('galleries', $filename, 'public');
            $gallery->images = [$path];
        }

        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = \App\Models\Gallery::findOrFail($id);
        // Hapus file dari storage jika ada
        if (is_array($gallery->images)) {
            foreach ($gallery->images as $img) {
                if (\Storage::disk('public')->exists($img)) {
                    \Storage::disk('public')->delete($img);
                }
            }
        }
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil dihapus.');
    }
}
