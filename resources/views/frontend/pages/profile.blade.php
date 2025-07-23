@extends('layouts.frontend')

@section('title', 'Profil Desa - Desa Karangrejo')
@section('description', 'Profil lengkap Desa Karangrejo meliputi data demografis, geografis, dan informasi umum desa')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold mb-3">Profil Desa Karangrejo</h1>
                <p class="lead mb-0">Informasi lengkap tentang Desa Karangrejo</p>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light">
    <div class="container">
        <ol class="breadcrumb py-3 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil Desa</li>
        </ol>
    </div>
</nav>

<!-- Profile Content -->
<section class="profile-section">
    <div class="container">
<!-- Hero Section -->
<section class="hero-section text-white py-5">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4 mb-lg-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Profil Desa</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3">Profil Desa Karangrejo</h1>
                <p class="lead mb-0">Mengenal lebih dekat dengan Desa Karangrejo melalui data dan informasi terkini</p>
            </div>
            <div class="col-lg-4 d-none d-lg-block">
                <div class="text-center">
                    <img src="{{ asset('img/village-illustration.svg') }}" alt="Desa Karangrejo" class="img-fluid" style="max-height: 200px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Profile Content -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <!-- Data Geografis -->
        @if($geography->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Data Geografis</h2>
                    <div class="section-line"></div>
                </div>
                <div class="row">
                    @forelse($geography as $item)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="stat-card bg-white shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon me-3">
                                        <i class="{{ $item->icon }}"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">{{ $item->label }}</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="value-display">{{ $item->value }}</div>
                                    </div>
                                    @if($item->description)
                                    <button type="button" class="btn btn-link p-0 text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->description }}">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Data Demografis -->
        @if($demographics->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Data Demografis</h2>
                    <div class="section-line"></div>
                </div>
                <div class="row">
                    @foreach($demographics as $item)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card bg-white shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="stat-icon mx-auto mb-3">
                                    <i class="{{ $item->icon }}"></i>
                                </div>
                                <div class="value-display mb-2">{{ $item->value }}</div>
                                <h6 class="text-muted mb-3">{{ $item->label }}</h6>
                                @if($item->description)
                                <button type="button" class="btn btn-link btn-sm text-muted p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->description }}">
                                    <i class="fas fa-info-circle me-1"></i> Detail
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Data Ekonomi -->
        @if($economy->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Data Ekonomi & Ketenagakerjaan</h2>
                    <div class="section-line"></div>
                </div>
                <div class="row">
                    @foreach($economy as $item)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="stat-card bg-white shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon me-3">
                                        <i class="{{ $item->icon }}"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">{{ $item->label }}</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="value-display">{{ $item->value }}</div>
                                    </div>
                                    @if($item->description)
                                    <button type="button" class="btn btn-link p-0 text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->description }}">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Data Pendidikan -->
        @if(isset($education) && $education->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Data Pendidikan</h2>
                    <div class="section-line"></div>
                </div>
                <div class="row">
                    @foreach($education as $item)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="stat-card bg-white shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon me-3">
                                        <i class="{{ $item->icon }}"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">{{ $item->label }}</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="value-display">{{ $item->value }}</div>
                                    </div>
                                    @if($item->description)
                                    <button type="button" class="btn btn-link p-0 text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->description }}">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Data Kesehatan -->
        @if(isset($health) && $health->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Data Kesehatan & Kesejahteraan</h2>
                    <div class="section-line"></div>
                </div>
                <div class="row">
                    @foreach($health as $item)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="stat-card bg-white shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon me-3">
                                        <i class="{{ $item->icon }}"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">{{ $item->label }}</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="value-display">{{ $item->value }}</div>
                                    </div>
                                    @if($item->description)
                                    <button type="button" class="btn btn-link p-0 text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->description }}">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Sejarah dan Visi Misi -->
        <div class="row">
            <!-- Sejarah Desa -->
            <div class="col-lg-6 mb-4">
                <div class="info-card bg-white shadow h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Sejarah Singkat</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Desa Karangrejo didirikan pada tahun 1945 oleh para sesepuh desa yang berasal dari berbagai daerah. Nama Karangrejo berasal dari kata "Karang" yang berarti batu dan "Rejo" yang berarti sejahtera.</p>
                        <p class="mb-4">Sejak didirikan, Desa Karangrejo terus mengalami perkembangan dalam berbagai bidang, mulai dari infrastruktur, pendidikan, kesehatan, hingga perekonomian masyarakat.</p>
                        <a href="#" class="btn btn-primary px-4">
                            <i class="fas fa-book-reader me-2"></i>Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>

            <!-- Visi Misi -->
            <div class="col-lg-6 mb-4">
                <div class="info-card bg-white shadow h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>Visi & Misi</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="fw-bold text-uppercase text-success mb-2">Visi</h6>
                            <p class="mb-0">"Mewujudkan Desa Karangrejo yang Maju, Mandiri, dan Sejahtera Berdasarkan Gotong Royong"</p>
                        </div>
                        
                        <div class="mb-4">
                            <h6 class="fw-bold text-uppercase text-success mb-2">Misi</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Meningkatkan kualitas pelayanan publik</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Mengembangkan potensi ekonomi lokal</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Memperkuat infrastruktur desa</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Memberdayakan masyarakat</li>
                            </ul>
                        </div>
                        <a href="#" class="btn btn-success px-4">
                            <i class="fas fa-arrow-right me-2"></i>Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover',
                html: true,
                boundary: 'window',
                customClass: 'profile-tooltip',
                offset: [0, 10]
            });
        });
        
        // Add animation on scroll
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.stat-card');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                if (elementTop < windowHeight - 100) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        };

        // Set initial state for animations
        document.querySelectorAll('.stat-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        });

        // Run once on load
        setTimeout(animateOnScroll, 100);
        
        // Run on scroll
        window.addEventListener('scroll', animateOnScroll);
    });
</script>
@endpush


@endsection