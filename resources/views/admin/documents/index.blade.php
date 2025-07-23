@extends('layouts.admin')

@section('title', 'Kelola Dokumen')
@section('page-title', 'Kelola Dokumen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Kelola Dokumen</h1>
        <p class="text-muted">Kelola dokumen publik desa</p>
    </div>
    <div class="alert alert-warning mb-0">Fitur dokumen telah dinonaktifkan.</div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Ukuran</th>
                        <th>Tipe File</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center text-muted">Fitur dokumen telah dinonaktifkan.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection
