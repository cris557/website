<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

// Redirect Halaman Utama & /home
Route::get('/', function () {
    return redirect()->route(Auth::check() ? 'dashboard' : 'login');
});
Route::redirect('/home', '/dashboard');

// Route Guest (Pengguna Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

// Route Authenticated (Pengguna Sudah Login & Akun Aktif)
Route::middleware(['auth', 'active'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil Pengguna (Bisa diakses Semua Role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Modul Khusus Admin (Kelola Pengguna & Hak Akses Hapus Data)
    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
        Route::delete('/matakuliah/{matakuliah}', [MatakuliahController::class, 'destroy'])->name('matakuliah.destroy');
        Route::delete('/nilai/{nilai}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
    });

    // Modul Admin & Dosen (Kelola Data Tanpa Akses Hapus)
    Route::middleware('role:Admin,Dosen')->group(function () {
        Route::resource('mahasiswa', MahasiswaController::class)->except('destroy');
        Route::resource('matakuliah', MatakuliahController::class)->except('destroy');
        Route::resource('nilai', NilaiController::class)->except('destroy');
    });
});