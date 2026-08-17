@extends('layouts.grain')
@section('title', 'Pengaturan Web')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengaturan Web</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4">
            <div class="h3 mb-0">Pengaturan Website</div>
        </div>

        <form method="POST" action="{{ route('web-setting.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Tab Navigation -->
            <ul class="nav nav-tabs mb-4" id="settingTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-about" data-toggle="tab" href="#about" role="tab">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-contact" data-toggle="tab" href="#contact" role="tab">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-social" data-toggle="tab" href="#social" role="tab">Media Sosial</a>
                </li>
            </ul>

            <div class="tab-content" id="settingTabsContent">

                <!-- About -->
                <div class="tab-pane fade show active" id="about" role="tabpanel">
                    <div class="form-group">
                        <label for="about_us_text">Teks Tentang Kami</label>
                        <textarea id="about_us_text" name="about_us_text" class="form-control" rows="6">{{ old('about_us_text', $setting->about_us_text ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="vision">Visi</label>
                        <textarea id="vision" name="vision" class="form-control" rows="3">{{ old('vision', $setting->vision ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="mission">Misi <small class="text-muted">(satu per baris)</small></label>
                        <textarea id="mission" name="mission" class="form-control" rows="5">{{ old('mission', isset($setting->mission) ? implode("\n", $setting->mission) : '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="about_image">Gambar Tentang Kami</label>
                        <input type="file" id="about_image" name="about_image" class="form-control-file" accept="image/*">
                        @if(isset($setting->about_image) && $setting->about_image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $setting->about_image) }}" alt="About Image"
                                     style="max-height: 150px; object-fit: cover;" class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact -->
                <div class="tab-pane fade" id="contact" role="tabpanel">
                    <div class="form-group">
                        <label for="contact_email">Email Kontak</label>
                        <input type="email" id="contact_email" name="contact_email" class="form-control"
                               value="{{ old('contact_email', $setting->contact_email ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="contact_phone">No. Telepon</label>
                        <input type="text" id="contact_phone" name="contact_phone" class="form-control"
                               value="{{ old('contact_phone', $setting->contact_phone ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea id="address" name="address" class="form-control" rows="3">{{ old('address', $setting->address ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="tab-pane fade" id="social" role="tabpanel">
                    <div class="form-group">
                        <label for="social_facebook">Facebook URL</label>
                        <input type="url" id="social_facebook" name="social_facebook" class="form-control"
                               value="{{ old('social_facebook', $setting->social_media['facebook'] ?? '') }}"
                               placeholder="https://facebook.com/...">
                    </div>
                    <div class="form-group">
                        <label for="social_instagram">Instagram URL</label>
                        <input type="url" id="social_instagram" name="social_instagram" class="form-control"
                               value="{{ old('social_instagram', $setting->social_media['instagram'] ?? '') }}"
                               placeholder="https://instagram.com/...">
                    </div>
                    <div class="form-group">
                        <label for="social_twitter">Twitter/X URL</label>
                        <input type="url" id="social_twitter" name="social_twitter" class="form-control"
                               value="{{ old('social_twitter', $setting->social_media['twitter'] ?? '') }}"
                               placeholder="https://twitter.com/...">
                    </div>
                    <div class="form-group">
                        <label for="social_youtube">YouTube URL</label>
                        <input type="url" id="social_youtube" name="social_youtube" class="form-control"
                               value="{{ old('social_youtube', $setting->social_media['youtube'] ?? '') }}"
                               placeholder="https://youtube.com/...">
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection
