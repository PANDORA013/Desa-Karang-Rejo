@extends('layouts.frontend')
@section('title', 'Struktur Organisasi Desa Karangrejo')
@section('description', 'Struktur Organisasi Pemerintahan Desa Karangrejo')
@section('content')
<div class="container py-4">
    <h1 class="mb-4">Struktur Organisasi Desa Karangrejo</h1>
    <img src="{{ asset('images/struktur-organisasi.png') }}" alt="Struktur Organisasi Desa" class="img-fluid mb-3" onerror="this.style.display='none'">
    <p>
        <!-- Tambahkan penjelasan atau upload gambar struktur organisasi di folder public/images/struktur-organisasi.png -->
    </p>
</div>
@endsection
