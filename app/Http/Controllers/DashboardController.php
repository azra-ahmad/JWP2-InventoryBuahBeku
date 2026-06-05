<?php

namespace App\Http\Controllers;

use App\Models\BuahBeku;
use App\Models\BuahBekuKeluar;
use App\Models\BuahBekuMasuk;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalProducts' => BuahBeku::count(),
            'totalStockIn' => BuahBekuMasuk::sum('jumlah'),
            'totalStockOut' => BuahBekuKeluar::sum('jumlah'),
            'currentInventory' => BuahBeku::sum('stok'),
            'lowestProducts' => BuahBeku::with('category')
                ->orderBy('stok')
                ->limit(5)
                ->get(),
            'highestProducts' => BuahBeku::with('category')
                ->orderByDesc('stok')
                ->limit(5)
                ->get(),
        ]);
    }
}
