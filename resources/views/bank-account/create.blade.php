@extends('layouts.grain')
@section('title', isset($bankAccount) ? 'Edit Rekening' : 'Tambah Rekening')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bank-account.index') }}">Rekening Bank</a></li>
                <li class="breadcrumb-item active">{{ isset($bankAccount) ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4">
            <div class="h3 mb-0">{{ isset($bankAccount) ? 'Edit Rekening Bank' : 'Tambah Rekening Bank Baru' }}</div>
        </div>

        <form method="POST"
              action="{{ isset($bankAccount) ? route('bank-account.update', $bankAccount) : route('bank-account.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($bankAccount)) @method('PATCH') @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bank_name">Nama Bank <span class="text-danger">*</span></label>
                        <input type="text" id="bank_name" name="bank_name" class="form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}"
                               value="{{ old('bank_name', $bankAccount->bank_name ?? '') }}" placeholder="BCA, BNI, Mandiri..." required>
                        @if($errors->has('bank_name')) <div class="invalid-feedback">{{ $errors->first('bank_name') }}</div> @endif
                    </div>

                    <div class="form-group">
                        <label for="account_number">Nomor Rekening <span class="text-danger">*</span></label>
                        <input type="text" id="account_number" name="account_number" class="form-control{{ $errors->has('account_number') ? ' is-invalid' : '' }}"
                               value="{{ old('account_number', $bankAccount->account_number ?? '') }}" required>
                        @if($errors->has('account_number')) <div class="invalid-feedback">{{ $errors->first('account_number') }}</div> @endif
                    </div>

                    <div class="form-group">
                        <label for="account_name">Atas Nama <span class="text-danger">*</span></label>
                        <input type="text" id="account_name" name="account_name" class="form-control{{ $errors->has('account_name') ? ' is-invalid' : '' }}"
                               value="{{ old('account_name', $bankAccount->account_name ?? '') }}" required>
                        @if($errors->has('account_name')) <div class="invalid-feedback">{{ $errors->first('account_name') }}</div> @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="logo">Logo Bank</label>
                        <input type="file" id="logo" name="logo" class="form-control-file" accept="image/*">
                        @if(isset($bankAccount) && $bankAccount->logo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $bankAccount->logo) }}" alt="Logo"
                                     style="height: 50px; object-fit: contain;" class="border rounded p-1">
                            </div>
                        @endif
                        @if($errors->has('logo')) <div class="invalid-feedback d-block">{{ $errors->first('logo') }}</div> @endif
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $bankAccount->is_active ?? true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Aktif (tampil di frontend)</label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex">
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('bank-account.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
