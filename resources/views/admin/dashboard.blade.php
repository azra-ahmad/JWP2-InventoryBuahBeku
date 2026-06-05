@extends('layouts.admin', ['title' => 'Dashboard - MeyJuice', 'pageTitle' => 'Dashboard'])

@section('content')
    @include('partials.page-header', [
        'title' => 'Dashboard',
        'subtitle' => 'Ringkasan kondisi dan pergerakan inventaris buah beku.',
    ])

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['Total Produk', $totalProducts, 'item', 'emerald'],
            ['Total Stok Masuk', $totalStockIn, 'kg', 'teal'],
            ['Total Stok Keluar', $totalStockOut, 'kg', 'sky'],
            ['Inventaris Saat Ini', $currentInventory, 'kg', 'slate'],
        ] as [$label, $value, $unit, $tone])
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $label }}</div>
                <div class="mt-2 text-2xl font-semibold">{{ number_format($value, 0, ',', '.') }} <span class="text-sm font-medium text-slate-400">{{ $unit }}</span></div>
            </div>
        @endforeach
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-4">
                <h2 class="font-semibold">Stok Terendah</h2>
                <p class="text-xs text-slate-500">Produk yang perlu dipantau lebih dulu.</p>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($lowestProducts as $product)
                    <div class="flex items-center justify-between p-4">
                        <div>
                            <div class="font-semibold">{{ $product->nama_produk }}</div>
                            <div class="text-xs text-slate-500">{{ $product->category?->nama_kategori }}</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-16 text-right text-sm font-semibold text-slate-700">{{ $product->stok }} {{ $product->satuan }}</span>
                            @if ($product->stok <= 0)
                                <span class="w-24 rounded-full border border-red-200 bg-red-50 px-2 py-0.5 text-center text-xs font-semibold text-red-700">Habis</span>
                            @elseif ($product->stok < 10)
                                <span class="w-24 rounded-full border border-amber-200 bg-amber-50 px-2 py-0.5 text-center text-xs font-semibold text-amber-700">Stok Rendah</span>
                            @else
                                <span class="w-24 rounded-full border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-center text-xs font-semibold text-emerald-700">Tersedia</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-sm text-slate-500">Belum ada produk.</div>
                @endforelse
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-4">
                <h2 class="font-semibold">Stok Tertinggi</h2>
                <p class="text-xs text-slate-500">Produk dengan persediaan terbesar.</p>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($highestProducts as $product)
                    <div class="flex items-center justify-between p-4">
                        <div>
                            <div class="font-semibold">{{ $product->nama_produk }}</div>
                            <div class="text-xs text-slate-500">{{ $product->category?->nama_kategori }}</div>
                        </div>
                        <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $product->stok }} {{ $product->satuan }}</span>
                    </div>
                @empty
                    <div class="p-4 text-sm text-slate-500">Belum ada produk.</div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
