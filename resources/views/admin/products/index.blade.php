@extends('layouts.admin', ['title' => 'Produk - MeyJuice', 'pageTitle' => 'Produk'])

@section('content')
    @include('partials.page-header', [
        'title' => 'Produk Buah Beku',
        'subtitle' => 'Kelola stok awal, harga, dan kategori produk.',
        'actions' => '<a href="' . route('admin.products.create') . '" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">Tambah Produk</a>',
    ])

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <form method="GET" class="grid gap-3 border-b border-slate-200 p-4 md:grid-cols-[1fr_220px_auto]">
            <input name="q" value="{{ $search }}" placeholder="Cari nama atau kode produk" class="rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            <select name="category_id" class="rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->nama_kategori }}</option>
                @endforeach
            </select>
            <button class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Filter</button>
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3 text-right">Stok</th>
                        <th class="px-4 py-3 text-right">Harga</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $product->kode_produk }}</td>
                            <td class="px-4 py-3">
                                <div class="font-semibold">{{ $product->nama_produk }}</div>
                                <a href="{{ route('admin.products.show', $product) }}" class="text-xs font-semibold text-emerald-700 hover:underline">Detail</a>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $product->category?->nama_kategori }}</td>
                            <td class="px-4 py-3 text-right font-semibold">{{ number_format($product->stok, 0, ',', '.') }} {{ $product->satuan }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format((float) $product->harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full border px-2.5 py-1 text-xs font-semibold {{ $product->status === 'In Stock' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : ($product->status === 'Low Stock' ? 'border-amber-200 bg-amber-50 text-amber-700' : 'border-red-200 bg-red-50 text-red-700') }}">{{ $product->status }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-slate-500">Belum ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 p-4">{{ $products->links() }}</div>
    </div>
@endsection
