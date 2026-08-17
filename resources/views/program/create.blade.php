@extends('layouts.grain')
@section('title', isset($program) ? 'Edit Program' : 'Tambah Program')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('program.index') }}">Program</a></li>
                <li class="breadcrumb-item active">{{ isset($program) ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4">
            <div class="h3 mb-0">{{ isset($program) ? 'Edit Program' : 'Tambah Program Baru' }}</div>
        </div>

        <form method="POST"
              action="{{ isset($program) ? route('program.update', $program) : route('program.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($program)) @method('PATCH') @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Judul Program <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                               value="{{ old('title', $program->title ?? '') }}" required>
                        @if($errors->has('title')) <div class="invalid-feedback">{{ $errors->first('title') }}</div> @endif
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug <span class="text-danger">*</span></label>
                        <input type="text" id="slug" name="slug" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                               value="{{ old('slug', $program->slug ?? '') }}" required>
                        @if($errors->has('slug')) <div class="invalid-feedback">{{ $errors->first('slug') }}</div> @endif
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" rows="8" required>{{ old('description', $program->description ?? '') }}</textarea>
                        @if($errors->has('description')) <div class="invalid-feedback">{{ $errors->first('description') }}</div> @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="category_id">Kategori <span class="text-danger">*</span></label>
                        <select id="category_id" name="category_id" class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $program->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('category_id')) <div class="invalid-feedback">{{ $errors->first('category_id') }}</div> @endif
                    </div>

                    <div class="form-group">
                        <label for="target_amount">Target Dana (Rp) <span class="text-danger">*</span></label>
                        <input type="number" id="target_amount" name="target_amount" class="form-control{{ $errors->has('target_amount') ? ' is-invalid' : '' }}"
                               value="{{ old('target_amount', $program->target_amount ?? '') }}" min="0" required>
                        @if($errors->has('target_amount')) <div class="invalid-feedback">{{ $errors->first('target_amount') }}</div> @endif
                    </div>

                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <input type="date" id="deadline" name="deadline" class="form-control"
                               value="{{ old('deadline', isset($program->deadline) ? \Carbon\Carbon::parse($program->deadline)->format('Y-m-d') : '') }}">
                    </div>

                    <div class="form-group">
                        <label for="distribution_date">Tanggal Penyaluran (Hari H)</label>
                        <input type="date" id="distribution_date" name="distribution_date" class="form-control"
                               value="{{ old('distribution_date', isset($program->distribution_date) ? \Carbon\Carbon::parse($program->distribution_date)->format('Y-m-d') : '') }}">
                        <small class="form-text text-muted">Tanggal kapan donasi ini akan/sudah disalurkan.</small>
                    </div>

                    <div class="form-group">
                        <label for="distribution_photos">Foto Penyaluran (Bisa pilih banyak)</label>
                        <input type="file" id="distribution_photos" name="distribution_photos[]" class="form-control-file" accept="image/*" multiple>
                        <small class="form-text text-muted">Upload dokumentasi penyaluran jika status sudah Selesai.</small>
                    </div>

                    <div class="form-group">
                        <label for="image">Gambar Program</label>
                        <input type="file" id="image" name="image" class="form-control-file{{ $errors->has('image') ? ' is-invalid' : '' }}" accept="image/*">
                        @if(isset($program) && $program->image)
                            <small class="form-text text-muted">Gambar saat ini: <a href="{{ asset('storage/' . $program->image) }}" target="_blank">Lihat</a></small>
                        @endif
                        @if($errors->has('image')) <div class="invalid-feedback">{{ $errors->first('image') }}</div> @endif
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $program->is_active ?? true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex">
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('program.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
