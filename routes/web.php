<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PetugasPerpustakaanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// <?php
// Route untuk halaman dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Routes untuk Buku
Route::resource('buku', BukuController::class);

// Routes untuk Siswa
Route::resource('siswa', SiswaController::class);

// Routes untuk Petugas Perpustakaan
Route::resource('petugas', PetugasPerpustakaanController::class);

// Routes untuk Peminjaman
Route::resource('peminjaman', PeminjamanController::class);
// Route tambahan untuk proses pengembalian buku
Route::patch('peminjaman/{peminjaman}/return', [PeminjamanController::class, 'returnBook'])->name('peminjaman.return');

// Routes untuk Denda
Route::resource('denda', DendaController::class);
// Route tambahan untuk pembayaran denda
Route::patch('denda/{denda}/pay', [DendaController::class, 'payFine'])->name('denda.pay');

// Routes untuk pencarian
Route::get('search/buku', [BukuController::class, 'search'])->name('buku.search');
Route::get('search/siswa', [SiswaController::class, 'search'])->name('siswa.search');
Route::get('search/peminjaman', [PeminjamanController::class, 'search'])->name('peminjaman.search');

// Route untuk laporan
Route::get('laporan/peminjaman', [PeminjamanController::class, 'report'])->name('peminjaman.report');
Route::get('laporan/denda', [DendaController::class, 'report'])->name('denda.report');