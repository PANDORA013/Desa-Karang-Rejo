@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Pengaturan Website</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="site_name" class="form-label">Nama Website *</label>
                        <input type="text" class="form-control" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="site_description" class="form-label">Deskripsi Website</label>
                        <textarea class="form-control" id="site_description" name="site_description" rows="2">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="site_keywords" class="form-label">Kata Kunci (SEO)</label>
                        <input type="text" class="form-control" id="site_keywords" name="site_keywords" value="{{ old('site_keywords', $settings['site_keywords'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Email Kontak</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label for="contact_phone" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label for="contact_address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="contact_address" name="contact_address" rows="2">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="facebook_url" class="form-label">Facebook</label>
                        <input type="text" class="form-control" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label for="instagram_url" class="form-label">Instagram</label>
                        <input type="text" class="form-control" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label for="youtube_url" class="form-label">YouTube</label>
                        <input type="text" class="form-control" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label for="whatsapp_number" class="form-label">WhatsApp</label>
                        <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label for="office_hours" class="form-label">Jam Operasional</label>
                        <input type="text" class="form-control" id="office_hours" name="office_hours" value="{{ old('office_hours', $settings['office_hours'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                        <input type="text" class="form-control" id="google_analytics_id" name="google_analytics_id" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
