@php
    $statusClass = [
        'In Stock' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'Low Stock' => 'border-amber-200 bg-amber-50 text-amber-700',
        'Out of Stock' => 'border-red-200 bg-red-50 text-red-700',
    ];
@endphp

<form method="GET" action="{{ $action }}" class="mb-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <input type="hidden" name="tab" value="{{ $tab }}">
    <div class="grid gap-3 md:grid-cols-4">
        <label class="block">
            <span class="mb-1 block text-xs font-semibold text-slate-500">Cari</span>
            <input name="q" value="{{ $filters['search'] }}" placeholder="Nama atau kode produk" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
        </label>
        <label class="block">
            <span class="mb-1 block text-xs font-semibold text-slate-500">Dari</span>
            <input type="date" name="from" value="{{ $filters['from'] }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
        </label>
        <label class="block">
            <span class="mb-1 block text-xs font-semibold text-slate-500">Sampai</span>
            <input type="date" name="to" value="{{ $filters['to'] }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
        </label>
        <div class="flex items-end gap-2">
            <button class="flex-1 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">Filter</button>
            <a href="{{ $action }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Reset</a>
        </div>
    </div>
</form>

<div class="mb-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Produk</div>
        <div class="mt-2 text-2xl font-semibold">{{ number_format($summary['totalProducts'], 0, ',', '.') }}</div>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Stok Sekarang</div>
        <div class="mt-2 text-2xl font-semibold">{{ number_format($summary['currentStock'], 0, ',', '.') }} kg</div>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Stok Masuk</div>
        <div class="mt-2 text-2xl font-semibold text-emerald-700">{{ number_format($summary['totalStockIn'], 0, ',', '.') }} kg</div>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Stok Keluar</div>
        <div class="mt-2 text-2xl font-semibold text-sky-700">{{ number_format($summary['totalStockOut'], 0, ',', '.') }} kg</div>
    </div>
</div>

<div x-data="{ tab: @js($tab) }" class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-col gap-3 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="inline-flex rounded-lg bg-slate-100 p-1">
            @foreach ([['inventory', 'Inventaris'], ['in', 'Stok Masuk'], ['out', 'Stok Keluar']] as [$value, $label])
                <a href="{{ request()->fullUrlWithQuery(['tab' => $value]) }}"
                    @click.prevent="tab = '{{ $value }}'; history.replaceState(null, '', $event.currentTarget.href)"
                    class="rounded-md px-3 py-1.5 text-sm font-semibold"
                    :class="tab === '{{ $value }}' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-900'">
                    {{ $label }}
                </a>
            @endforeach
        </div>
        <div class="text-xs text-slate-500">Data laporan dibuat dari tabel transaksi dan stok produk.</div>
    </div>

    <div x-show="tab === 'inventory'">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3 text-right">Stok</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($inventoryRows as $product)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $product->kode_produk }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $product->nama_produk }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $product->category?->nama_kategori }}</td>
                            <td class="px-4 py-3 text-right font-semibold">{{ number_format($product->stok, 0, ',', '.') }} {{ $product->satuan }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusClass[$product->status] }}">{{ $product->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Tidak ada data inventaris.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 p-4">{{ $inventoryRows->links() }}</div>
    </div>

    <div x-show="tab === 'in'">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($stockInRows as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">{{ $row->tanggal_masuk->format('d M Y') }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $row->product?->nama_produk }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $row->keterangan ?: '-' }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-emerald-700">+{{ number_format($row->jumlah, 0, ',', '.') }} kg</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">Tidak ada data stok masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 p-4">{{ $stockInRows->links() }}</div>
    </div>

    <div x-show="tab === 'out'">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($stockOutRows as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">{{ $row->tanggal_keluar->format('d M Y') }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $row->product?->nama_produk }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $row->keterangan ?: '-' }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-sky-700">-{{ number_format($row->jumlah, 0, ',', '.') }} kg</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">Tidak ada data stok keluar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 p-4">{{ $stockOutRows->links() }}</div>
    </div>
</div>
