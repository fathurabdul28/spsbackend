@extends('layouts.grain')
@section('title', isset($news) ? 'Edit Berita' : 'Tambah Berita')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Berita</a></li>
                <li class="breadcrumb-item active">{{ isset($news) ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4">
            <div class="h3 mb-0">{{ isset($news) ? 'Edit Berita' : 'Tambah Berita Baru' }}</div>
        </div>

        <form method="POST"
              action="{{ isset($news) ? route('news.update', $news) : route('news.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($news)) @method('PATCH') @endif

            <div class="form-group">
                <label for="title">Judul Berita <span class="text-danger">*</span></label>
                <input type="text" id="title" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                       value="{{ old('title', $news->title ?? '') }}" required>
                @if($errors->has('title')) <div class="invalid-feedback">{{ $errors->first('title') }}</div> @endif
            </div>

            <div class="form-group">
                <label for="slug">Slug <span class="text-danger">*</span></label>
                <input type="text" id="slug" name="slug" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                       value="{{ old('slug', $news->slug ?? '') }}" required>
                @if($errors->has('slug')) <div class="invalid-feedback">{{ $errors->first('slug') }}</div> @endif
            </div>

            <div class="form-group">
                <label for="content">Konten <span class="text-danger">*</span></label>
                <textarea id="content" name="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" rows="12" required>{{ old('content', $news->content ?? '') }}</textarea>
                @if($errors->has('content')) <div class="invalid-feedback">{{ $errors->first('content') }}</div> @endif
            </div>

            <div class="form-group">
                <label for="image">Gambar Thumbnail</label>
                <input type="file" id="image" name="image" class="form-control-file" accept="image/*">
                @if(isset($news) && $news->image)
                    <small class="form-text text-muted">Gambar saat ini: <a href="{{ asset('storage/' . $news->image) }}" target="_blank">Lihat</a></small>
                @endif
                @if($errors->has('image')) <div class="invalid-feedback d-block">{{ $errors->first('image') }}</div> @endif
            </div>

            <hr>
            <div class="d-flex">
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('news.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
