<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

// ── Auth ──
Route::get('/',      [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Protected routes (harus login) ──
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // POS
    Route::get('/pos/eceran',  [TransaksiController::class, 'eceran'])->name('pos.eceran');
    Route::get('/pos/grosir',  [TransaksiController::class, 'grosir'])->name('pos.grosir');
    Route::post('/pos/simpan', [TransaksiController::class, 'store'])->name('pos.store');

    // Riwayat Transaksi
    Route::get('/transaksi',         [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}',    [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('/transaksi/retur',  [TransaksiController::class, 'retur'])->name('transaksi.retur');

    // Inventaris & Barang
    Route::get('/inventaris',            [BarangController::class, 'inventaris'])->name('inventaris');
    Route::resource('/barang', BarangController::class);
    Route::post('/barang/import',        [BarangController::class, 'import'])->name('barang.import');

    // Laporan (hanya owner)
    Route::middleware('role:owner')->group(function () {
        Route::get('/laporan/penjualan',  [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
        Route::get('/laporan/keuangan',   [LaporanController::class, 'keuangan'])->name('laporan.keuangan');
    });
});