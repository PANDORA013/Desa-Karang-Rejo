@extends('layouts.frontend')

@section('title', 'Beranda - Desa Karangrejo')
@section('description', 'Website resmi Desa Karangrejo - Informasi terkini seputar kegiatan, layanan, dan pembangunan desa')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="--hero-bg: url('{{ asset('storage/images/hero-bg.jpg') }}?v={{ time() }}')">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h1 class="display-4 fw-bold mb-4">Selamat Datang di Desa Karangrejo</h1>
                <p class="lead mb-4">Desa yang maju, mandiri, dan sejahtera dengan pelayanan terbaik untuk masyarakat</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('profile') }}" class="btn btn-light btn-lg mb-2 mb-md-0">
                        <i class="fas fa-info-circle me-2"></i>Profil Desa
                    </a>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-newspaper me-2"></i>Berita Terkini
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row text-center">
            @foreach($villageStats as $stat)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-primary mb-3">
                            <i class="{{ $stat->icon }} fa-3x"></i>
                        </div>
                        <h3 class="stats-counter">{{ $stat->value }}</h3>
                        <h6 class="text-muted">{{ $stat->label }}</h6>
                        <p class="small text-muted">{{ $stat->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Announcements Section -->
@if($announcements->count() > 0)
<section class="py-4 announcement-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-2">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-bullhorn text-warning me-2"></i>Pengumuman
                </h6>
            </div>
            <div class="col-md-10">
                <div id="announcementCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($announcements as $index => $announcement)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="d-flex align-items-center">
                                @if($announcement->priority === 'urgent')
                                    <span class="badge bg-danger me-2">URGENT</span>
                                @elseif($announcement->priority === 'high')
                                    <span class="badge bg-warning me-2">PENTING</span>
                                @endif
                                <span>{{ $announcement->title }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Latest News Section -->
<section class="section-padding">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-6">
                <h2 class="fw-bold">Berita Terkini</h2>
                <p class="text-muted">Informasi terbaru seputar kegiatan dan perkembangan Desa Karangrejo</p>
            </div>
            <div class="col-lg-6 text-lg-end">
                <a href="{{ route('posts.index') }}" class="btn btn-primary">
                    Lihat Semua Berita <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        
        <div class="row">
            @forelse($latestPosts as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    @if($post->featured_image)
                    <img src="{{ $post->featured_image_url }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-primary">{{ $post->category->name }}</span>
                            <small class="text-muted ms-2">{{ $post->published_at->format('d M Y') }}</small>
                        </div>
                        <h5 class="card-title">
                            <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                                {{ $post->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted flex-grow-1">{{ $post->excerpt }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>{{ $post->user->name }}
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>{{ $post->views }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada berita tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Section layanan dihapus -->

@endsection

@push('scripts')
<script>
    // Auto-rotate announcements
    if (document.getElementById('announcementCarousel')) {
        var announcementCarousel = new bootstrap.Carousel(document.getElementById('announcementCarousel'), {
            interval: 5000,
            wrap: true
        });
    }
    
    // Animate counters
    function animateCounters() {
        const counters = document.querySelectorAll('.stats-counter');
        
        counters.forEach(counter => {
            const target = parseInt(counter.textContent.replace(/,/g, ''));
            if (!isNaN(target)) {
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current).toLocaleString();
                    }
                }, 20);
            }
        });
    }
    
    // Trigger animation when stats section is in view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    });
    
    const statsSection = document.querySelector('.section-padding.bg-light');
    if (statsSection) {
        observer.observe(statsSection);
    }
</script>
@endpush