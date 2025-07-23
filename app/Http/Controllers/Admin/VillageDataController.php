<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageData;
use Illuminate\Http\Request;

class VillageDataController extends Controller
{
    public function index(Request $request)
    {
        $query = VillageData::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('label', 'like', '%' . $request->search . '%');
        }

        $villageData = $query->orderBy('type')->orderBy('sort_order')->paginate(15);

        return view('admin.village-data.index', compact('villageData'));
    }

    public function create()
    {
        return view('admin.village-data.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:demografi,geografis,ekonomi,pendidikan,kesehatan',
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0'
        ], [
            'type.required' => 'Tipe data wajib dipilih.',
            'label.required' => 'Label data wajib diisi.',
            'value.required' => 'Nilai data wajib diisi.',
            'sort_order.integer' => 'Urutan harus berupa angka.'
        ]);

        VillageData::create($request->all());

        return redirect()->route('admin.village-data.index')
            ->with('success', 'Data desa berhasil ditambahkan.');
    }

    public function show($village_datum)
    {
        $villageData = VillageData::findOrFail($village_datum);
        return view('admin.village-data.show', compact('villageData'));
    }

    public function edit(VillageData $village_datum)
    {
        return view('admin.village-data.edit', ['villageData' => $village_datum]);
    }

    public function update(Request $request, VillageData $village_datum)
    {
        $request->validate([
            'type' => 'required|in:demografi,geografis,ekonomi,pendidikan,kesehatan',
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $village_datum->update($request->all());

        return redirect()->route('admin.village-data.index')
            ->with('success', 'Data desa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $villageData = VillageData::findOrFail($id);
        $villageData->delete();

        return redirect()->route('admin.village-data.index')
            ->with('success', 'Data desa berhasil dihapus.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:village_data,id'
        ]);

        try {
            $count = VillageData::whereIn('id', $request->ids)->count();
            VillageData::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "{$count} data desa berhasil dihapus."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data.'
            ], 500);
        }
    }
}