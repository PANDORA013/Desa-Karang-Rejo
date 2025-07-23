<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $documents = $query->latest()->paginate(15);

        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240'
        ], [
            'title.required' => 'Judul dokumen wajib diisi.',
            'file.required' => 'File dokumen wajib diupload.',
            'file.mimes' => 'File harus berformat PDF, DOC, DOCX, XLS, XLSX, PPT, atau PPTX.',
            'file.max' => 'Ukuran file maksimal 10MB.'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'public');

            Document::create([
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'category' => $request->category,
                'status' => $request->status
            ]);
        }

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diupload.');
    }

    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240'
        ]);

        $data = $request->except('file');

        // Handle file upload if new file provided
        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete($document->file_path);

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'public');

            $data['file_path'] = $path;
            $data['file_type'] = $file->getClientMimeType();
            $data['file_size'] = $file->getSize();
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        // Delete file from storage
        Storage::disk('public')->delete($document->file_path);

        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Download the specified document.
     *
     * @param Document $document
     * @return \Illuminate\Http\RedirectResponse|StreamedResponse
     */
    public function download(Document $document)
    {
        // First, check if the file exists on the specified disk.
        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        // Increment the download count (assuming this method exists on your model).
        $document->incrementDownloads();

        // Get the full path to the file.
        $fullPath = Storage::disk('public')->path($document->file_path);

        // Create a new filename for the download, using the document's title and original extension.
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        $downloadName = $document->title . '.' . $extension;

        // Return a download response using the response() helper.
        return response()->download($fullPath, $downloadName);
    }

    public function toggleStatus(Document $document)
    {
        $newStatus = $document->status === 'active' ? 'inactive' : 'active';
        $document->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => "Status dokumen berhasil diubah menjadi {$newStatus}.",
            'status' => $newStatus
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:documents,id'
        ]);

        try {
            $documentsQuery = Document::whereIn('id', $request->ids);
            $count = $documentsQuery->count();
            $message = '';

            switch ($request->action) {
                case 'delete':
                    // We need to get the documents before deleting to access file_path
                    $documentsToDelete = $documentsQuery->get();
                    foreach ($documentsToDelete as $document) {
                        Storage::disk('public')->delete($document->file_path);
                        $document->delete(); // Delete the record
                    }
                    $message = "{$count} dokumen berhasil dihapus.";
                    break;
                case 'activate':
                    $documentsQuery->update(['status' => 'active']);
                    $message = "{$count} dokumen berhasil diaktifkan.";
                    break;
                case 'deactivate':
                    $documentsQuery->update(['status' => 'inactive']);
                    $message = "{$count} dokumen berhasil dinonaktifkan.";
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            // Log the error for debugging
            // Log::error('Bulk action failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat melakukan aksi bulk.'
            ], 500);
        }
    }
}
