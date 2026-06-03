<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockOutRequest;
use App\Models\BuahBeku;
use App\Models\BuahBekuKeluar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockOutController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $transactions = BuahBekuKeluar::with('product')
            ->when($search, fn ($query) => $query->whereHas('product', function ($product) use ($search) {
                $product->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('kode_produk', 'like', "%{$search}%");
            }))
            ->latest('tanggal_keluar')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.stock-out.index', compact('transactions', 'search'));
    }

    public function create(): View
    {
        return view('admin.stock-out.form', [
            'transaction' => new BuahBekuKeluar(['tanggal_keluar' => now()]),
            'products' => BuahBeku::orderBy('nama_produk')->get(),
        ]);
    }

    public function store(StockOutRequest $request): RedirectResponse
    {
        $failed = false;

        DB::transaction(function () use ($request, &$failed) {
            $data = $request->validated();
            $product = BuahBeku::whereKey($data['buah_beku_id'])->lockForUpdate()->firstOrFail();

            if ($product->stok < $data['jumlah']) {
                $failed = true;
                return;
            }

            $product->decrement('stok', $data['jumlah']);
            BuahBekuKeluar::create($data);
        });

        if ($failed) {
            return back()->withInput()->with('error', 'Stok tidak mencukupi untuk transaksi keluar.');
        }

        return redirect()->route('admin.stock-out.index')->with('success', 'Transaksi stok keluar berhasil disimpan.');
    }

    public function edit(BuahBekuKeluar $stockOut): View
    {
        return view('admin.stock-out.form', [
            'transaction' => $stockOut,
            'products' => BuahBeku::orderBy('nama_produk')->get(),
        ]);
    }

    public function update(StockOutRequest $request, BuahBekuKeluar $stockOut): RedirectResponse
    {
        $failed = false;

        DB::transaction(function () use ($request, $stockOut, &$failed) {
            $data = $request->validated();

            if ((int) $stockOut->buah_beku_id === (int) $data['buah_beku_id']) {
                $product = BuahBeku::whereKey($stockOut->buah_beku_id)->lockForUpdate()->firstOrFail();
                $available = $product->stok + $stockOut->jumlah;

                if ($available < $data['jumlah']) {
                    $failed = true;
                    return;
                }

                $product->update(['stok' => $available - $data['jumlah']]);
            } else {
                $oldProduct = BuahBeku::whereKey($stockOut->buah_beku_id)->lockForUpdate()->firstOrFail();
                $newProduct = BuahBeku::whereKey($data['buah_beku_id'])->lockForUpdate()->firstOrFail();

                if ($newProduct->stok < $data['jumlah']) {
                    $failed = true;
                    return;
                }

                $oldProduct->increment('stok', $stockOut->jumlah);
                $newProduct->decrement('stok', $data['jumlah']);
            }

            $stockOut->update($data);
        });

        if ($failed) {
            return back()->withInput()->with('error', 'Stok tidak mencukupi untuk perubahan transaksi keluar.');
        }

        return redirect()->route('admin.stock-out.index')->with('success', 'Transaksi stok keluar berhasil diperbarui.');
    }

    public function destroy(BuahBekuKeluar $stockOut): RedirectResponse
    {
        DB::transaction(function () use ($stockOut) {
            BuahBeku::whereKey($stockOut->buah_beku_id)->lockForUpdate()->firstOrFail()->increment('stok', $stockOut->jumlah);
            $stockOut->delete();
        });

        return redirect()->route('admin.stock-out.index')->with('success', 'Transaksi stok keluar berhasil dihapus.');
    }
}
