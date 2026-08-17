@extends('layouts.grain')
@section('title', 'Berita')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Berita</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4 d-flex justify-content-between align-items-center">
            <div class="h3 mb-0">Kelola Berita</div>
            <div>
                <a href="{{ route('export.news.excel', request()->query()) }}" class="btn btn-success btn-sm mr-2">
                    <i class="gd-download icon-text"></i> Export Excel
                </a>
                <a href="{{ route('export.news.pdf', request()->query()) }}" class="btn btn-danger btn-sm mr-2">
                    <i class="gd-file icon-text"></i> Export PDF
                </a>
                <a href="{{ route('news.create') }}" class="btn btn-primary btn-sm">
                    <i class="gd-plus icon-text"></i> Tambah Berita
                </a>
            </div>
        </div>

        <div class="table-responsive-xl">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="font-weight-semi-bold border-top-0 py-2">#</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Judul</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Penulis</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Dibuat</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($news as $item)
                    <tr>
                        <td class="py-3">{{ $loop->iteration + ($news->currentPage() - 1) * $news->perPage() }}</td>
                        <td class="py-3">{{ Str::limit($item->title, 60) }}</td>
                        <td class="py-3">{{ $item->author->name ?? '-' }}</td>
                        <td class="py-3">{{ $item->created_at->diffForHumans() }}</td>
                        <td class="py-3">
                            <a class="link-dark d-inline-block mr-2" href="{{ route('news.edit', $item) }}" title="Edit">
                                <i class="gd-pencil icon-text"></i>
                            </a>
                            <a class="link-dark d-inline-block text-danger" href="#"
                               onclick="if(confirm('Hapus berita ini?')){document.getElementById('delete-news-{{ $item->id }}').submit(); return false;}">
                                <i class="gd-trash icon-text"></i>
                            </a>
                            <form id="delete-news-{{ $item->id }}" action="{{ route('news.destroy', $item) }}" method="POST" style="display:none;">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-3">Belum ada berita.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $news->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection
