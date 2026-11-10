<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/beranda', [DashboardController::class, 'beranda'])->name('beranda');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified', 'role:admin,guru,siswa'])
    ->name('dashboard');

Route::middleware(['auth', 'role:admin,guru,siswa'])->group(function () {
    Route::resource('siswa', SiswaController::class)
        ->only(['index', 'show'])
        ->whereNumber('siswa');
    Route::resource('guru', GuruController::class)
        ->only(['index', 'show'])
        ->whereNumber('guru');
    Route::resource('kelas', KelasController::class)
        ->only(['index', 'show'])
        ->whereNumber('kelas');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil');
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('/guru', [GuruController::class, 'index'])->name('guru');
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('siswa', SiswaController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->whereNumber('siswa');
});

Route::middleware(['auth', 'guru'])->group(function () {
    Route::resource('guru', GuruController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->whereNumber('guru');
    Route::resource('kelas', KelasController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->whereNumber('kelas');
});

Route::middleware(['auth', 'role:admin,guru,siswa'])->get('/siswa/{nama}', [DashboardController::class, 'namaSiswa'])
    ->whereAlpha('nama')
    ->name('siswa.by-name');

require __DIR__.'/auth.php';
