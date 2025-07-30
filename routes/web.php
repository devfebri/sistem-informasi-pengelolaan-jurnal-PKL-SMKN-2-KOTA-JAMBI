<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GuruMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::resource('jurnal', JurnalController::class);
    Route::resource('penilaian', PenilaianController::class)->middleware(GuruMiddleware::class);
    Route::resource('instansi', InstansiController::class)->middleware(AdminMiddleware::class);
    Route::resource('user', UserController::class)->middleware(AdminMiddleware::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
});
