@extends('layouts.admin')

@section('title', 'Lihat Berita')
@section('page-title', 'Lihat Berita')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Detail Berita</h6>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <h3>{{ $post->title }}</h3>
                <div class="mb-2">
                    <span class="badge bg-secondary">{{ $post->category->name }}</span>
                    <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">{{ ucfirst($post->status) }}</span>
                    <span class="text-muted ms-2"><i class="fas fa-user"></i> {{ $post->user->name ?? '-' }}</span>
                    <span class="text-muted ms-2"><i class="fas fa-calendar"></i> {{ $post->created_at->format('d M Y H:i') }}</span>
                </div>
                @if($post->featured_image_url)
                <div class="mb-3">
                    <img src="{{ $post->featured_image_url }}" alt="Gambar Unggulan" class="img-fluid rounded" style="max-height:300px;">
                </div>
                @endif
                <div class="mb-3">
                    <strong>Ringkasan:</strong>
                    <div class="text-muted">{!! nl2br(e($post->excerpt)) !!}</div>
                </div>
                <div class="mb-3">
                    <strong>Isi Berita:</strong>
                    <div>{!! $post->content !!}</div>
                </div>
                <div class="mb-3">
                    <span class="text-muted"><i class="fas fa-eye"></i> {{ $post->views }} views</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
