@extends('layouts.grain')
@section('title', 'Kategori')

@section('content')
@include('components.notification')

<div class="card mb-3 mb-md-4">
    <div class="card-body">
        <nav class="d-none d-md-block" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Kategori</li>
            </ol>
        </nav>

        <div class="mb-3 mb-md-4 d-flex justify-content-between align-items-center">
            <div class="h3 mb-0">Kelola Kategori</div>
            <a href="{{ route('category.create') }}" class="btn btn-primary">
                <i class="gd-plus icon-text"></i> Tambah Kategori
            </a>
        </div>

        <div class="table-responsive-xl">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="font-weight-semi-bold border-top-0 py-2">#</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Nama</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Slug</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Dibuat</th>
                        <th class="font-weight-semi-bold border-top-0 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="py-3">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                        <td class="py-3">{{ $category->name }}</td>
                        <td class="py-3"><code>{{ $category->slug }}</code></td>
                        <td class="py-3">{{ $category->created_at->diffForHumans() }}</td>
                        <td class="py-3">
                            <a class="link-dark d-inline-block mr-2" href="{{ route('category.edit', $category) }}" title="Edit">
                                <i class="gd-pencil icon-text"></i>
                            </a>
                            <a class="link-dark d-inline-block text-danger" href="#"
                               onclick="if(confirm('Hapus kategori ini?')){document.getElementById('delete-cat-{{ $category->id }}').submit(); return false;}">
                                <i class="gd-trash icon-text"></i>
                            </a>
                            <form id="delete-cat-{{ $category->id }}" action="{{ route('category.destroy', $category) }}" method="POST" style="display:none;">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-3">Belum ada kategori.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $categories->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection
