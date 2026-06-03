@extends('layouts.admin', ['title' => ($product->exists ? 'Edit' : 'Tambah') . ' Produk - MeyJuice', 'pageTitle' => 'Produk'])

@section('content')
    @include('partials.page-header', [
        'title' => $product->exists ? 'Edit Produk' : 'Tambah Produk',
        'subtitle' => 'Gunakan data sesuai struktur tabel buah_beku.',
    ])

    <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" class="max-w-3xl rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif
        <div class="grid gap-4 md:grid-cols-2">
            <label class="block">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Kode Produk</span>
                <input name="kode_produk" value="{{ old('kode_produk', $product->kode_produk) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
            <label class="block">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Nama Produk</span>
                <input name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
            <label class="block">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Kategori</span>
                <select name="kategori_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    <option value="">Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('kategori_id', $product->kategori_id) === (string) $category->id)>{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Satuan</span>
                <input name="satuan" value="{{ old('satuan', $product->satuan) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
            <label class="block">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Stok</span>
                <input type="number" min="0" name="stok" value="{{ old('stok', $product->stok) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
            <label class="block">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Harga</span>
                <input type="number" min="0" step="0.01" name="harga" value="{{ old('harga', $product->harga) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
        </div>
        <div class="mt-5 flex gap-2">
            <button class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Batal</a>
        </div>
    </form>
@endsection
