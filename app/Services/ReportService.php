<?php

namespace App\Services;

use App\Models\BuahBeku;
use App\Models\BuahBekuKeluar;
use App\Models\BuahBekuMasuk;
use Illuminate\Http\Request;

class ReportService
{
    public function build(Request $request): array
    {
        $search = trim((string) $request->query('q', ''));
        $from = $request->query('from');
        $to = $request->query('to');
        $tab = $request->query('tab', 'inventory');

        $stockInQuery = BuahBekuMasuk::with('product.category')
            ->when($from, fn ($query) => $query->whereDate('tanggal_masuk', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('tanggal_masuk', '<=', $to))
            ->when($search, fn ($query) => $query->whereHas('product', function ($product) use ($search) {
                $product->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('kode_produk', 'like', "%{$search}%");
            }));

        $stockOutQuery = BuahBekuKeluar::with('product.category')
            ->when($from, fn ($query) => $query->whereDate('tanggal_keluar', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('tanggal_keluar', '<=', $to))
            ->when($search, fn ($query) => $query->whereHas('product', function ($product) use ($search) {
                $product->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('kode_produk', 'like', "%{$search}%");
            }));

        $inventoryQuery = BuahBeku::with('category')
            ->when($search, fn ($query) => $query->where(function ($nested) use ($search) {
                $nested->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('kode_produk', 'like', "%{$search}%")
                    ->orWhereHas('category', fn ($category) => $category->where('nama_kategori', 'like', "%{$search}%"));
            }));

        return [
            'tab' => in_array($tab, ['inventory', 'in', 'out'], true) ? $tab : 'inventory',
            'filters' => compact('search', 'from', 'to'),
            'summary' => [
                'totalProducts' => (clone $inventoryQuery)->count(),
                'currentStock' => (clone $inventoryQuery)->sum('stok'),
                'totalStockIn' => (clone $stockInQuery)->sum('jumlah'),
                'totalStockOut' => (clone $stockOutQuery)->sum('jumlah'),
            ],
            'inventoryRows' => $inventoryQuery->orderBy('nama_produk')->paginate(8, ['*'], 'inventory_page')->withQueryString(),
            'stockInRows' => $stockInQuery->latest('tanggal_masuk')->latest('id')->paginate(8, ['*'], 'in_page')->withQueryString(),
            'stockOutRows' => $stockOutQuery->latest('tanggal_keluar')->latest('id')->paginate(8, ['*'], 'out_page')->withQueryString(),
        ];
    }
}
