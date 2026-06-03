@extends('layouts.admin', ['title' => ($category->exists ? 'Edit' : 'Tambah') . ' Kategori - MeyJuice', 'pageTitle' => 'Kategori'])

@section('content')
    @include('partials.page-header', [
        'title' => $category->exists ? 'Edit Kategori' : 'Tambah Kategori',
        'subtitle' => 'Nama kategori digunakan untuk mengelompokkan produk.',
    ])

    <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="max-w-xl rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif
        <label class="block">
            <span class="mb-1 block text-sm font-semibold text-slate-700">Nama Kategori</span>
            <input name="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
        </label>
        <div class="mt-5 flex gap-2">
            <button class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Batal</a>
        </div>
    </form>
@endsection
