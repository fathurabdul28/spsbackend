@extends('layouts.grain')
@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active">{{ isset($category) ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4">
            <div class="h3 mb-0">{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</div>
        </div>

        <form method="POST"
              action="{{ isset($category) ? route('category.update', $category) : route('category.store') }}">
            @csrf
            @if(isset($category)) @method('PATCH') @endif

            <div class="form-group">
                <label for="name">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                       value="{{ old('name', $category->name ?? '') }}" required>
                @if($errors->has('name')) <div class="invalid-feedback">{{ $errors->first('name') }}</div> @endif
            </div>

            <div class="form-group">
                <label for="slug">Slug <span class="text-danger">*</span></label>
                <input type="text" id="slug" name="slug" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                       value="{{ old('slug', $category->slug ?? '') }}" required>
                @if($errors->has('slug')) <div class="invalid-feedback">{{ $errors->first('slug') }}</div> @endif
            </div>

            <hr>
            <div class="d-flex">
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('category.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
