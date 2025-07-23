@extends('layouts.frontend')
@section('title', 'Struktur Organisasi Desa Karangrejo')
@section('description', 'Struktur Organisasi Pemerintahan Desa Karangrejo')
@section('content')
<div class="container py-4">
    <h1 class="mb-4">Struktur Organisasi Desa Karangrejo</h1>
    <img src="{{ asset('images/struktur-organisasi.png') }}" alt="Struktur Organisasi Desa" class="img-fluid mb-3" onerror="this.style.display='none'">
    <div class="row">
        @if(isset($officials) && count($officials))
            <ul class="list-group list-group-flush">
                @foreach($officials as $official)
                    <li class="list-group-item">
                        <strong>{{ $official->name }}</strong> - {{ ucfirst($official->role) }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>Data struktur organisasi belum tersedia.</p>
        @endif
    </div>
</div>
@endsection
