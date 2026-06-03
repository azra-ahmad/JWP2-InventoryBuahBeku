<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\BuahBeku;
use App\Models\KategoriBuahBeku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $categoryId = $request->query('category_id');
        $categories = KategoriBuahBeku::orderBy('nama_kategori')->get();

        $products = BuahBeku::with('category')
            ->when($search, fn ($query) => $query->where(function ($nested) use ($search) {
                $nested->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('kode_produk', 'like', "%{$search}%");
            }))
            ->when($categoryId, fn ($query) => $query->where('kategori_id', $categoryId))
            ->orderBy('nama_produk')
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'categories', 'search', 'categoryId'));
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new BuahBeku(['satuan' => 'kg', 'stok' => 0, 'harga' => 0]),
            'categories' => KategoriBuahBeku::orderBy('nama_kategori')->get(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        BuahBeku::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(BuahBeku $product): View
    {
        $product->load('category', 'stockIns', 'stockOuts');

        return view('admin.products.show', compact('product'));
    }

    public function edit(BuahBeku $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => KategoriBuahBeku::orderBy('nama_kategori')->get(),
        ]);
    }

    public function update(ProductRequest $request, BuahBeku $product): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        } else {
            unset($data['gambar']);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(BuahBeku $product): RedirectResponse
    {
        if ($product->stockIns()->exists() || $product->stockOuts()->exists()) {
            return back()->with('error', 'Produk tidak bisa dihapus karena memiliki riwayat transaksi.');
        }

        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
