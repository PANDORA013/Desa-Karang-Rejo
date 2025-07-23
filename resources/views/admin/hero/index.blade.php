@extends('admin.layouts.app')

@section('title', 'Pengaturan Hero Section')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-image me-2"></i>Pengaturan Hero Section
                    </h5>
                </div>
                <div class="card-body">
                    <form id="heroBackgroundForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="background_image" class="form-label">Unggah Gambar Background</label>
                            <input class="form-control" type="file" id="background_image" name="background_image" accept="image/*" required>
                            <div class="form-text">Ukuran rekomendasi: minimal 1920x1080px. Format: JPG, PNG, atau GIF. Maksimal 2MB.</div>
                        </div>
                        
                        <div class="preview-container mb-4">
                            <h6 class="mb-3">Pratinjau</h6>
                            <div class="border rounded p-4 text-center hero-preview" style="--hero-bg-image: url('{{ asset('storage/images/hero-bg.jpg') }}?v={{ time() }}')">
                                <div class="d-flex flex-column justify-content-center h-100">
                                    <h2 class="text-white mb-4">Selamat Datang di Desa Karangrejo</h2>
                                    <p class="text-white-50 mb-4">Ini adalah pratinjau bagaimana tampilan hero section Anda</p>
                                    <div>
                                        <button type="button" class="btn btn-light me-2">Profil Desa</button>
                                        <button type="button" class="btn btn-outline-light">Berita Terkini</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" id="saveButton">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('heroBackgroundForm');
        const fileInput = document.getElementById('background_image');
        const previewContainer = document.querySelector('.preview-container');
        const saveButton = document.getElementById('saveButton');
        const originalButtonText = saveButton.innerHTML;
        
        // Preview image before upload
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = previewContainer.querySelector('.hero-preview');
                    preview.classList.add('active');
                    preview.style.setProperty('--hero-bg-image', `url(${e.target.result})`);
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Handle form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            // Show loading state
            saveButton.disabled = true;
            saveButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';
            
            // Send AJAX request
            fetch('{{ route("admin.hero.background.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Background hero section berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Update preview with new image
                    const preview = previewContainer.querySelector('.hero-preview');
                    preview.style.setProperty('--hero-bg-image', `url(${data.path}?v=${new Date().getTime()})`);
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: error.message || 'Terjadi kesalahan saat mengunggah gambar.',
                    timer: 3000
                });
            })
            .finally(() => {
                // Reset button state
                saveButton.disabled = false;
                saveButton.innerHTML = originalButtonText;
            });
        });
    });
</script>
@endpush

@push('styles')
<style>
    .preview-container .hero-preview {
        height: 300px;
        background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6));
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        transition: background-image 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .hero-preview {
        background-image: var(--hero-bg-image, none);
    }
</style>
@endpush
@endsection
