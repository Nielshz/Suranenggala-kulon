<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Artisan;

// ═══════════════════════════════════
//  PUBLIC ROUTES (no auth required)
// ═══════════════════════════════════

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/install-database-sekarang', function () {
    try {
        Artisan::call('migrate:fresh', ['--force' => true, '--seed' => true]);
        return response('✅ DATABASE ONLINE (SUPABASE) SUKSES DI-INSTALL & AKUN ADMIN TELAH DIBUAT! SILAKAN LOGIN.', 200)
                  ->header('Content-Type', 'text/plain');
    } catch (\Exception $e) {
        return response('Gagal: ' . $e->getMessage(), 500)->header('Content-Type', 'text/plain');
    }
});

// Public: Laporan warga
Route::get('/laporan/buat', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/laporan/buat', [LaporanController::class, 'store'])->name('laporan.store');

// ═══════════════════════════════════
//  PROTECTED ROUTES (auth required)
// ═══════════════════════════════════

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Warga Import/Export
    Route::get('warga/export', [WargaController::class, 'export'])->name('warga.export');
    Route::get('warga/template', [WargaController::class, 'downloadTemplate'])->name('warga.template');
    Route::get('warga/import', [WargaController::class, 'importForm'])->name('warga.import');
    Route::post('warga/import', [WargaController::class, 'import'])->name('warga.import.process');

    // Warga CRUD
    Route::resource('warga', WargaController::class);

    // Kartu Keluarga CRUD
    Route::resource('kartu-keluarga', KartuKeluargaController::class);
    Route::get('kartu-keluarga/{kartu_keluarga}/edit-anggota', [KartuKeluargaController::class, 'editAnggota'])->name('kartu-keluarga.edit-anggota');
    Route::put('kartu-keluarga/{kartu_keluarga}/update-anggota', [KartuKeluargaController::class, 'updateAnggota'])->name('kartu-keluarga.update-anggota');

    // Mutasi
    Route::get('mutasi', [MutasiController::class, 'index'])->name('mutasi.index');
    Route::get('mutasi/create', [MutasiController::class, 'create'])->name('mutasi.create');
    Route::post('mutasi', [MutasiController::class, 'store'])->name('mutasi.store');
    Route::get('mutasi/{mutasi}', [MutasiController::class, 'show'])->name('mutasi.show');
    Route::delete('mutasi/{mutasi}', [MutasiController::class, 'destroy'])->name('mutasi.destroy');

    // Pengumuman (Admin)
    Route::resource('pengumuman', PengumumanController::class)->except(['show']);

    // Laporan (Admin view)
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::put('laporan/{laporan}/respond', [LaporanController::class, 'respond'])->name('laporan.respond');
    Route::delete('laporan/{laporan}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

    // User management (Admin + RT only)
    Route::middleware([\App\Http\Middleware\CheckRole::class . ':Admin,RT'])->group(function () {
        Route::resource('user', UserController::class);
    });

    // Galeri
    Route::get('galeri', [GaleriController::class, 'index'])->name('galeri.index');
    Route::get('galeri/create', [GaleriController::class, 'create'])->name('galeri.create');
    Route::post('galeri', [GaleriController::class, 'store'])->name('galeri.store');
    Route::delete('galeri/{galeri}', [GaleriController::class, 'destroy'])->name('galeri.destroy');
});
