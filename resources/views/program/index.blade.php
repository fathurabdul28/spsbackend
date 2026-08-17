@extends('layouts.grain')
@section('title', 'Program')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Program</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4 d-flex justify-content-between align-items-center">
            <div class="h3 mb-0">Program Donasi</div>
            <div>
                <a href="{{ route('export.programs.excel', request()->query()) }}" class="btn btn-success btn-sm mr-2">
                    <i class="gd-download icon-text"></i> Export Excel
                </a>
                <a href="{{ route('export.programs.pdf', request()->query()) }}" class="btn btn-danger btn-sm mr-2">
                    <i class="gd-file icon-text"></i> Export PDF
                </a>
                <a href="{{ route('program.create') }}" class="btn btn-primary btn-sm">
                    <i class="gd-plus icon-text"></i> Tambah Program
                </a>
            </div>
        </div>

        <div class="table-responsive-xl">
            <table class="table text-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="font-weight-semi-bold border-top-0 py-2">#</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Judul</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Kategori</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Target</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Status</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Dibuat</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($programs as $program)
                    <tr>
                        <td class="py-3">{{ $loop->iteration + ($programs->currentPage() - 1) * $programs->perPage() }}</td>
                        <td class="align-middle py-3">{{ Str::limit($program->title, 50) }}</td>
                        <td class="py-3">{{ $program->category->name ?? '-' }}</td>
                        <td class="py-3">Rp {{ number_format($program->target_amount, 0, ',', '.') }}</td>
                        <td class="py-3">
                            @if($program->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-3">{{ $program->created_at->diffForHumans() }}</td>
                        <td class="py-3">
                            <a class="link-dark d-inline-block mr-2" href="{{ route('program.edit', $program) }}" title="Edit">
                                <i class="gd-pencil icon-text"></i>
                            </a>
                            <a class="link-dark d-inline-block text-danger" href="#"
                               onclick="if(confirm('Hapus program ini?')){document.getElementById('delete-program-{{ $program->id }}').submit(); return false;}">
                                <i class="gd-trash icon-text"></i>
                            </a>
                            <form id="delete-program-{{ $program->id }}" action="{{ route('program.destroy', $program) }}" method="POST" style="display:none;">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-3">Belum ada program.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $programs->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection
