@extends('layouts.admin', ['title' => 'Detail Produk - MeyJuice', 'pageTitle' => 'Produk'])

@section('content')
    @include('partials.page-header', [
        'title' => $product->nama_produk,
        'subtitle' => 'Detail produk dan ringkasan transaksi.',
        'actions' => '<a href="' . route('admin.products.edit', $product) . '" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">Edit Produk</a>',
    ])

    <div class="grid gap-4 lg:grid-cols-3">
        <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
            <dl class="grid gap-4 sm:grid-cols-2">
                <div><dt class="text-xs font-semibold uppercase text-slate-400">Kode</dt><dd class="mt-1 font-semibold">{{ $product->kode_produk }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-400">Kategori</dt><dd class="mt-1 font-semibold">{{ $product->category?->nama_kategori }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-400">Stok</dt><dd class="mt-1 font-semibold">{{ number_format($product->stok, 0, ',', '.') }} {{ $product->satuan }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-400">Harga</dt><dd class="mt-1 font-semibold">Rp {{ number_format((float) $product->harga, 0, ',', '.') }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-400">Stok Masuk</dt><dd class="mt-1 font-semibold">{{ number_format($product->stockIns->sum('jumlah'), 0, ',', '.') }} {{ $product->satuan }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-400">Stok Keluar</dt><dd class="mt-1 font-semibold">{{ number_format($product->stockOuts->sum('jumlah'), 0, ',', '.') }} {{ $product->satuan }}</dd></div>
            </dl>
        </section>
        <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-xs font-semibold uppercase text-slate-400">Status</div>
            <div class="mt-2 text-2xl font-semibold">{{ $product->status }}</div>
            @if ($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->nama_produk }}" class="mt-4 aspect-video w-full rounded-lg object-cover">
            @else
                <div class="mt-4 grid aspect-video place-items-center rounded-lg bg-slate-100 text-sm text-slate-500">Tidak ada gambar</div>
            @endif
        </section>
    </div>
@endsection
