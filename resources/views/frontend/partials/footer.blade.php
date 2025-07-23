<footer class="footer mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-white mb-3">{{ $settings['site_name'] ?? 'Desa Karangrejo' }}</h5>
                <p class="mb-3">{{ $settings['site_description'] ?? 'Website resmi Desa Karangrejo yang menyediakan informasi terkini tentang kegiatan, layanan, dan pembangunan desa.' }}</p>
                <div class="d-flex gap-3">
                    @if(!empty($settings['facebook_url']))
                    <a href="{{ $settings['facebook_url'] }}" class="text-decoration-none" target="_blank">
                        <i class="fab fa-facebook-f fa-lg"></i>
                    </a>
                    @endif
                    @if(!empty($settings['instagram_url']))
                    <a href="{{ $settings['instagram_url'] }}" class="text-decoration-none" target="_blank">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    @endif
                    @if(!empty($settings['youtube_url']))
                    <a href="{{ $settings['youtube_url'] }}" class="text-decoration-none" target="_blank">
                        <i class="fab fa-youtube fa-lg"></i>
                    </a>
                    @endif
                    @if(!empty($settings['whatsapp_number']))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_number']) }}" class="text-decoration-none" target="_blank">
                        <i class="fab fa-whatsapp fa-lg"></i>
                    </a>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-5 col-md-6 mb-4 d-flex justify-content-center">
                <div>
                    <h6 class="text-white mb-3">Menu Utama</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('profile') }}">Profil Desa</a></li>
                        <li class="mb-2"><a href="{{ route('posts.index') }}">Berita</a></li>
                        <li class="mb-2"><a href="{{ route('galleries.index') }}">Galeri</a></li>
                        <li class="mb-2"><a href="{{ route('contact.index') }}">Kontak</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="text-white mb-3">Kontak Kami</h6>
                <div class="d-flex mb-2">
                    <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                    <span>{!! nl2br(e($settings['contact_address'] ?? 'Jl. Raya Karangrejo No. 123, Kecamatan Sukodadi, Kabupaten Lamongan, Jawa Timur')) !!}</span>
                </div>
                <div class="d-flex mb-2">
                    <i class="fas fa-phone me-3 mt-1"></i>
                    <span>{{ $settings['contact_phone'] ?? '(0322) 123456' }}</span>
                </div>
                <div class="d-flex mb-2">
                    <i class="fas fa-envelope me-3 mt-1"></i>
                    <span>{{ $settings['contact_email'] ?? 'info@desakarangrejo.id' }}</span>
                </div>
                <div class="d-flex">
                    <i class="fas fa-clock me-3 mt-1"></i>
                    <span>{{ $settings['office_hours'] ?? 'Senin - Jumat: 08:00 - 16:00' }}</span>
                </div>
            </div>
        </div>
        
        <hr class="my-4" style="border-color: var(--gray-600);">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} Desa Karangrejo. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0">Developed by</i> Kelompok 2 KKN UISI</p>
                 {{-- <i class="fas fa-heart text-danger"> --}}
            </div>
        </div>
    </div>
</footer>