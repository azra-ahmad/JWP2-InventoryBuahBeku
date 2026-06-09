<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
// use App\Http\Controllers\PublicReportController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:admin')->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::get('/reports', AdminReportController::class)->name('reports.index');

        Route::resource('categories', CategoryController::class)
            ->except('show')
            ->parameters(['categories' => 'category']);

        Route::resource('products', ProductController::class)
            ->parameters(['products' => 'product']);

        Route::resource('stock-in', StockInController::class)
            ->except('show')
            ->parameters(['stock-in' => 'stockIn']);

        Route::resource('stock-out', StockOutController::class)
            ->except('show')
            ->parameters(['stock-out' => 'stockOut']);

        Route::resource('users', AdminController::class)
            ->except('show')
            ->parameters(['users' => 'admin']);
    });
