@extends('layouts.admin')

@section('title', 'Tambah Dokumen')
@section('page-title', 'Tambah Dokumen')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Dokumen</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">Fitur dokumen telah dinonaktifkan.</div>
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
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
