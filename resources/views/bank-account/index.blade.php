@extends('layouts.grain')
@section('title', 'Rekening Bank')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Rekening Bank</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4 d-flex justify-content-between align-items-center">
            <div class="h3 mb-0">Kelola Rekening Bank</div>
            <a href="{{ route('bank-account.create') }}" class="btn btn-primary">
                <i class="gd-plus icon-text"></i> Tambah Rekening
            </a>
        </div>

        <div class="row">
        @forelse($bankAccounts as $account)
            <div class="col-md-6 col-xl-4 mb-3">
                <div class="card h-100 {{ $account->is_active ? '' : 'border-secondary' }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if($account->logo)
                                <img src="{{ asset('storage/' . $account->logo) }}" alt="{{ $account->bank_name }}"
                                     style="height: 40px; object-fit: contain;" class="mr-3">
                            @else
                                <div class="icon icon-lg bg-soft-primary rounded-circle mr-3">
                                    <i class="gd-credit-card icon-text text-primary"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-0">{{ $account->bank_name }}</h5>
                                @if($account->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </div>
                        </div>
                        <p class="mb-1"><strong>No. Rekening:</strong> {{ $account->account_number }}</p>
                        <p class="mb-3"><strong>Atas Nama:</strong> {{ $account->account_name }}</p>
                        <div class="d-flex">
                            <a href="{{ route('bank-account.edit', $account) }}" class="btn btn-sm btn-outline-primary mr-2">Edit</a>
                            <form action="{{ route('bank-account.destroy', $account) }}" method="POST" class="d-inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Hapus rekening ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 text-muted">Belum ada rekening bank yang terdaftar.</div>
            </div>
        @endforelse
        </div>

        {{ $bankAccounts->links('components.pagination') }}
    </div>
</div>
@endsection
