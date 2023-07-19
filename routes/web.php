<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanBulananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanMingguanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login')->middleware('guest');
    Route::post('/', 'authenticate');
    Route::post('/logout', 'logout');
});

Route::prefix('/dashboard')->group(function () {
    Route::resource('/', DashboardController::class)->middleware('auth');

    Route::resource('/user', UserController::class)->middleware('auth');
    Route::post('/user/reset-password', [UserController::class, 'resetPassword'])->middleware('auth');

    Route::resource('/kategori', KategoriController::class)->middleware('auth');

    Route::resource('/barang', BarangController::class)->middleware('auth');
    Route::post('/barang/tambah-stock', [BarangController::class, 'storeStock'])->name('barang.stock')->middleware('auth');

    Route::resource('/peminjaman', PeminjamanController::class)->middleware('auth');

    Route::put('/peminjaman', [PeminjamanController::class, 'approve'])->name('peminjaman.approve')->middleware('auth');

    Route::prefix('/laporan')->group(function () {
        Route::resource('/laporan-utama', LaporanController::class)->middleware('auth');

        Route::resource('/laporan-mingguan', LaporanMingguanController::class)->middleware('auth');
        Route::resource('/laporan-bulanan', LaporanBulananController::class)->middleware('auth');
    });
});
