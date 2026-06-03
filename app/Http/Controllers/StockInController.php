<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockInRequest;
use App\Models\BuahBeku;
use App\Models\BuahBekuMasuk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockInController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $transactions = BuahBekuMasuk::with('product')
            ->when($search, fn ($query) => $query->whereHas('product', function ($product) use ($search) {
                $product->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('kode_produk', 'like', "%{$search}%");
            }))
            ->latest('tanggal_masuk')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.stock-in.index', compact('transactions', 'search'));
    }

    public function create(): View
    {
        return view('admin.stock-in.form', [
            'transaction' => new BuahBekuMasuk(['tanggal_masuk' => now()]),
            'products' => BuahBeku::orderBy('nama_produk')->get(),
        ]);
    }

    public function store(StockInRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $product = BuahBeku::whereKey($data['buah_beku_id'])->lockForUpdate()->firstOrFail();
            $product->increment('stok', $data['jumlah']);
            BuahBekuMasuk::create($data);
        });

        return redirect()->route('admin.stock-in.index')->with('success', 'Transaksi stok masuk berhasil disimpan.');
    }

    public function edit(BuahBekuMasuk $stockIn): View
    {
        return view('admin.stock-in.form', [
            'transaction' => $stockIn,
            'products' => BuahBeku::orderBy('nama_produk')->get(),
        ]);
    }

    public function update(StockInRequest $request, BuahBekuMasuk $stockIn): RedirectResponse
    {
        DB::transaction(function () use ($request, $stockIn) {
            $data = $request->validated();

            if ((int) $stockIn->buah_beku_id === (int) $data['buah_beku_id']) {
                $product = BuahBeku::whereKey($stockIn->buah_beku_id)->lockForUpdate()->firstOrFail();
                $product->increment('stok', $data['jumlah'] - $stockIn->jumlah);
            } else {
                BuahBeku::whereKey($stockIn->buah_beku_id)->lockForUpdate()->firstOrFail()->decrement('stok', $stockIn->jumlah);
                BuahBeku::whereKey($data['buah_beku_id'])->lockForUpdate()->firstOrFail()->increment('stok', $data['jumlah']);
            }

            $stockIn->update($data);
        });

        return redirect()->route('admin.stock-in.index')->with('success', 'Transaksi stok masuk berhasil diperbarui.');
    }

    public function destroy(BuahBekuMasuk $stockIn): RedirectResponse
    {
        DB::transaction(function () use ($stockIn) {
            BuahBeku::whereKey($stockIn->buah_beku_id)->lockForUpdate()->firstOrFail()->decrement('stok', $stockIn->jumlah);
            $stockIn->delete();
        });

        return redirect()->route('admin.stock-in.index')->with('success', 'Transaksi stok masuk berhasil dihapus.');
    }
}
