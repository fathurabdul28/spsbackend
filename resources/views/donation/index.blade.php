@extends('layouts.grain')
@section('title', 'Donasi')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Donasi</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4 d-flex justify-content-between align-items-center">
            <div class="h3 mb-0">Kelola Donasi</div>
            <div>
                <a href="{{ route('export.donations.excel', request()->query()) }}" class="btn btn-success btn-sm mr-2 rounded-pill shadow-sm px-3">
                    <i class="gd-download icon-text"></i> Export Excel
                </a>
                <a href="{{ route('export.donations.pdf', request()->query()) }}" class="btn btn-danger btn-sm rounded-pill shadow-sm px-3">
                    <i class="gd-file icon-text"></i> Export PDF
                </a>
            </div>
        </div>

        <!-- Filter -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama/email donatur..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="settlement" {{ request('status') === 'settlement' ? 'selected' : '' }}>Sukses</option>
                        <option value="cancel" {{ request('status') === 'cancel' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('donation.index') }}" class="btn btn-secondary w-100 rounded-pill shadow-sm">Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive-xl">
            <table class="table text-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="font-weight-semi-bold border-top-0 py-2">#</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Donatur</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Program</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Jumlah</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Metode</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Status</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Tanggal</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($donations as $donation)
                    <tr>
                        <td class="py-2">{{ $loop->iteration + ($donations->currentPage() - 1) * $donations->perPage() }}</td>
                        <td class="align-middle py-2">
                            <div class="font-weight-semi-bold">{{ $donation->donor_name }}</div>
                            <small class="text-muted">{{ $donation->donor_email }}</small>
                        </td>
                        <td class="py-2">{{ Str::limit($donation->program->title ?? '-', 30) }}</td>
                        <td class="py-2 font-weight-semi-bold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td class="py-2">{{ $donation->payment_type ?? 'Manual' }}</td>
                        <td class="py-2">
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
                        <td class="py-2">{{ $donation->created_at->format('d/m/Y') }}</td>
                        <td class="py-2">
                            <a href="{{ route('donation.show', $donation) }}" class="btn btn-sm btn-info rounded-pill shadow-sm py-0 px-2 mr-1" title="Detail">
                                <i class="gd-eye icon-text text-white"></i>
                            </a>
                            @if($donation->status === 'pending')
                            <form action="{{ route('donation.confirm', $donation) }}" method="POST" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success rounded-pill shadow-sm py-0 px-2 mr-1" title="Konfirmasi" onclick="return confirm('Konfirmasi donasi ini?')">
                                    <i class="gd-check icon-text"></i>
                                </button>
                            </form>
                            @endif
                            <a href="#" class="btn btn-sm btn-danger rounded-pill shadow-sm py-0 px-2"
                               onclick="if(confirm('Hapus data ini?')){document.getElementById('delete-donation-{{ $donation->id }}').submit(); return false;}">
                                <i class="gd-trash icon-text text-white"></i>
                            </a>
                            <form id="delete-donation-{{ $donation->id }}" action="{{ route('donation.destroy', $donation) }}" method="POST" style="display:none;">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-3">Belum ada data donasi.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $donations->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection
