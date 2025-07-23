@extends('layouts.admin')

@section('title', 'Edit Galeri')
@section('page-title', 'Edit Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Galeri</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $gallery->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="foto" {{ old('category', $gallery->category) == 'foto' ? 'selected' : '' }}>Foto</option>
                            <option value="video" {{ old('category', $gallery->category) == 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File Baru (opsional)</label>
                        <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <img id="preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                        @if(is_array($gallery->images) && count($gallery->images) > 0)
                            <div class="mt-2">
                                <label class="form-label">File Saat Ini:</label>
                                <ul>
                                    @foreach($gallery->images as $img)
                                        <li><a href="{{ asset('storage/' . $img) }}" target="_blank">{{ $img }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $gallery->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const imagePreview = document.getElementById('imagePreview');
    const preview = document.getElementById('preview');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                preview.src = '';
            }
        } else {
            imagePreview.style.display = 'none';
            preview.src = '';
        }
    });
});
</script>
@endpush
