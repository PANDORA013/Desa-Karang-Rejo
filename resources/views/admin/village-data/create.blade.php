@extends('layouts.admin')

@section('title', 'Tambah Data Desa')
@section('page-title', 'Tambah Data Desa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Form Tambah Data Desa</h6>
                <a href="{{ route('admin.village-data.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.village-data.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="label" class="form-label fw-bold">Label *</label>
                        <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label') }}" required>
                        @error('label')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="value" class="form-label fw-bold">Nilai *</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value') }}" required>
                        @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label fw-bold">Tipe Data *</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Pilih Tipe Data</option>
                            <option value="demografi" {{ old('type') == 'demografi' ? 'selected' : '' }}>Demografi</option>
                            <option value="geografis" {{ old('type') == 'geografis' ? 'selected' : '' }}>Geografis</option>
                            <option value="ekonomi" {{ old('type') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                            <option value="pendidikan" {{ old('type') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="kesehatan" {{ old('type') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="form-label fw-bold">Ikon</label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon') }}" placeholder="Contoh: fas fa-home">
                        <small class="text-muted">Gunakan class ikon dari Font Awesome (contoh: fas fa-home)</small>
                        @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="sort_order" class="form-label fw-bold">Urutan</label>
                        <input type="number" min="0" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                        @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Data
                        </button>
                        <a href="{{ route('admin.village-data.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
