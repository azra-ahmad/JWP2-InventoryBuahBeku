@extends('layouts.admin', ['title' => 'Stok Masuk - MeyJuice', 'pageTitle' => 'Stok Masuk'])

@section('content')
    @include('partials.page-header', [
        'title' => 'Stok Masuk',
        'subtitle' => 'Catat dan kelola transaksi penambahan stok.',
        'actions' => '<a href="' . route('admin.stock-in.create') . '" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">Tambah Stok Masuk</a>',
    ])

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <form method="GET" class="flex flex-col gap-3 border-b border-slate-200 p-4 sm:flex-row">
            <input name="q" value="{{ $search }}" placeholder="Cari produk" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:max-w-sm">
            <button class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Cari</button>
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3 text-right">Jumlah</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">{{ $transaction->tanggal_masuk->format('d M Y') }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $transaction->product?->nama_produk }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $transaction->keterangan ?: '-' }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-emerald-700">+{{ number_format($transaction->jumlah, 0, ',', '.') }} kg</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.stock-in.edit', $transaction) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.stock-in.destroy', $transaction) }}" onsubmit="return confirm('Hapus transaksi stok masuk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada transaksi stok masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 p-4">{{ $transactions->links() }}</div>
    </div>
@endsection
