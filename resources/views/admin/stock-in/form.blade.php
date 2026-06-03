@extends('layouts.admin', ['title' => ($transaction->exists ? 'Edit' : 'Tambah') . ' Stok Masuk - MeyJuice', 'pageTitle' => 'Stok Masuk'])

@section('content')
    @include('partials.page-header', [
        'title' => $transaction->exists ? 'Edit Stok Masuk' : 'Tambah Stok Masuk',
        'subtitle' => 'Perubahan transaksi otomatis menyesuaikan stok produk.',
    ])

    <form method="POST" action="{{ $transaction->exists ? route('admin.stock-in.update', $transaction) : route('admin.stock-in.store') }}" class="max-w-2xl rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        @csrf
        @if ($transaction->exists)
            @method('PUT')
        @endif
        <div class="grid gap-4 md:grid-cols-2">
            <label class="block md:col-span-2">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Produk</span>
                <select name="buah_beku_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    <option value="">Pilih produk</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected((string) old('buah_beku_id', $transaction->buah_beku_id) === (string) $product->id)>{{ $product->kode_produk }} - {{ $product->nama_produk }} ({{ $product->stok }} {{ $product->satuan }})</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Jumlah</span>
                <input type="number" min="1" name="jumlah" value="{{ old('jumlah', $transaction->jumlah) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
            <label class="block">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Tanggal Masuk</span>
                <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', optional($transaction->tanggal_masuk)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
            <label class="block md:col-span-2">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Keterangan</span>
                <textarea name="keterangan" rows="3" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">{{ old('keterangan', $transaction->keterangan) }}</textarea>
            </label>
        </div>
        <div class="mt-5 flex gap-2">
            <button class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Simpan</button>
            <a href="{{ route('admin.stock-in.index') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Batal</a>
        </div>
    </form>
@endsection
