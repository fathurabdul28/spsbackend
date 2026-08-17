@extends('layouts.grain')
@section('title', 'Detail Donasi')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('donation.index') }}">Donasi</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4 d-flex justify-content-between align-items-center">
            <div class="h3 mb-0">Detail Donasi</div>
            <div>
                @if($donation->status === 'pending')
                <form action="{{ route('donation.confirm', $donation) }}" method="POST" class="d-inline-block mr-2">
                    @csrf
                    <button type="submit" class="btn btn-success rounded-pill shadow-sm px-4" onclick="return confirm('Konfirmasi donasi ini?')">
                        <i class="gd-check icon-text"></i> Konfirmasi
                    </button>
                </form>
                <form action="{{ route('donation.reject', $donation) }}" method="POST" class="d-inline-block">
                    @csrf
                    <button type="submit" class="btn btn-danger rounded-pill shadow-sm px-4" onclick="return confirm('Tolak donasi ini?')">
                        <i class="gd-close icon-text"></i> Tolak
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Donatur</h5>
                <table class="table table-borderless">
                    <tr>
                        <td class="pl-0 font-weight-semi-bold" width="40%">Nama</td>
                        <td>: {{ $donation->donor_name }}</td>
                    </tr>
                    <tr>
                        <td class="pl-0 font-weight-semi-bold">Email</td>
                        <td>: {{ $donation->donor_email }}</td>
                    </tr>
                    <tr>
                        <td class="pl-0 font-weight-semi-bold">No. Telepon</td>
                        <td>: {{ $donation->donor_phone ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Donasi</h5>
                <table class="table table-borderless">
                    <tr>
                        <td class="pl-0 font-weight-semi-bold" width="40%">Program</td>
                        <td>: {{ $donation->program->title ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pl-0 font-weight-semi-bold">Jumlah</td>
                        <td>: <strong>Rp {{ number_format($donation->amount, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td class="pl-0 font-weight-semi-bold">Metode</td>
                        <td>: {{ $donation->payment_type ?? 'Manual Transfer' }}</td>
                    </tr>
                    <tr>
                        <td class="pl-0 font-weight-semi-bold">Status</td>
                        <td>:
                            @if($donation->status === 'settlement')
                                <span class="badge badge-success">Sukses</span>
                            @elseif($donation->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($donation->status === 'cancel')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @else
                                <span class="badge badge-secondary">{{ $donation->status }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="pl-0 font-weight-semi-bold">Tanggal</td>
                        <td>: {{ $donation->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                    @if($donation->payment_type === 'manual')
                    <tr>
                        <td class="pl-0 font-weight-semi-bold">Bukti Transfer</td>
                        <td>: 
                            @if($donation->proof_of_payment)
                                <a href="{{ asset('storage/' . $donation->proof_of_payment) }}" target="_blank" class="btn btn-sm btn-info rounded-pill text-white py-1 px-3 shadow-sm">
                                    <i class="gd-image icon-text"></i> Lihat Gambar
                                </a>
                            @else
                                <span class="text-danger font-weight-bold">Belum diupload</span>
                            @endif
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <hr>
        <a href="{{ route('donation.index') }}" class="btn btn-secondary rounded-pill shadow-sm px-4">
            <i class="gd-arrow-left icon-text"></i> Kembali
        </a>
    </div>
</div>
@endsection
