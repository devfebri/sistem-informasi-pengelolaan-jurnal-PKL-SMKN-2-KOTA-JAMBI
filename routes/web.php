<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PenilaianBerkalaController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GuruMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('jurnal', JurnalController::class);
    Route::post('jurnal/{jurnal}/validate', [JurnalController::class, 'validateJurnal'])->middleware(GuruMiddleware::class);
    Route::resource('penilaian', PenilaianController::class)->middleware(GuruMiddleware::class);
    
    // Route penilaian-berkala: siswa bisa akses index dan show, guru bisa akses semua
    Route::get('penilaian-berkala', [PenilaianBerkalaController::class, 'index'])->name('penilaian-berkala.index');
    Route::middleware(GuruMiddleware::class)->group(function () {
        Route::get('penilaian-berkala/create', [PenilaianBerkalaController::class, 'create'])->name('penilaian-berkala.create');
        Route::post('penilaian-berkala', [PenilaianBerkalaController::class, 'store'])->name('penilaian-berkala.store');
        Route::get('penilaian-berkala/{penilaian_berkala}/edit', [PenilaianBerkalaController::class, 'edit'])->name('penilaian-berkala.edit');
        Route::put('penilaian-berkala/{penilaian_berkala}', [PenilaianBerkalaController::class, 'update'])->name('penilaian-berkala.update');
        Route::delete('penilaian-berkala/{penilaian_berkala}', [PenilaianBerkalaController::class, 'destroy'])->name('penilaian-berkala.destroy');
    });
    Route::get('penilaian-berkala/{penilaian_berkala}', [PenilaianBerkalaController::class, 'show'])->name('penilaian-berkala.show');
    
    Route::resource('instansi', InstansiController::class)->middleware(AdminMiddleware::class);
    Route::resource('user', UserController::class)->middleware(AdminMiddleware::class);
    Route::resource('siswa', SiswaController::class)->middleware(AdminMiddleware::class);
    Route::resource('guru', GuruController::class)->middleware(AdminMiddleware::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    
    // Routes Laporan (Hanya untuk pimpinan dan admin)
    Route::prefix('laporan')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/lengkap', [LaporanController::class, 'laporanLengkap'])->name('laporan.lengkap');
        Route::get('/siswa', [LaporanController::class, 'laporanSiswa'])->name('laporan.siswa');
        Route::get('/instansi', [LaporanController::class, 'laporanInstansi'])->name('laporan.instansi');
        Route::get('/guru', [LaporanController::class, 'laporanGuru'])->name('laporan.guru');
    });
});
