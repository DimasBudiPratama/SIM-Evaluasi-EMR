<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KuesionerPiecesController;
use App\Http\Controllers\KuesionerTamController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RespondenController;
use App\Http\Controllers\RiwayatController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LandingController::class, 'index']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pertanyaan
    Route::prefix('pertanyaan')->group(function () {
        Route::get('/index', [PertanyaanController::class, 'index'])->name('pertanyaan.index');
        Route::post('/store/', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
        Route::put('/update/{id}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
        Route::delete('/delete/{id}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');
    });

    // Responden
    Route::prefix('responden')->group(function () {
        Route::get('/index', [RespondenController::class, 'index'])->name('responden.index');
        Route::post('/store/', [RespondenController::class, 'store'])->name('responden.store');
        Route::put('/update/{id}', [RespondenController::class, 'update'])->name('responden.update');
        Route::delete('/delete/{id}', [RespondenController::class, 'destroy'])->name('responden.destroy');
    });

    // Kuesioner PIECES
    Route::prefix('kuesioner-pieces')->group(function () {
        Route::get('/index', [KuesionerPiecesController::class, 'index'])->name('kuesioner-pieces.index');
        Route::post('/store/', [KuesionerPiecesController::class, 'store'])->name('kuesioner-pieces.store');
        Route::put('/update/{id}', [KuesionerPiecesController::class, 'update'])->name('kuesioner-pieces.update');
        Route::delete('/delete/{id}', [KuesionerPiecesController::class, 'destroy'])->name('kuesioner-pieces.destroy');
    });

    // Kuesioner TAM
    Route::prefix('kuesioner-tam')->group(function () {
        Route::get('/index', [KuesionerTamController::class, 'index'])->name('kuesioner-tam.index');
        Route::post('/store/', [KuesionerTamController::class, 'store'])->name('kuesioner-tam.store');
        Route::put('/update/{id}', [KuesionerTamController::class, 'update'])->name('kuesioner-tam.update');
        Route::delete('/delete/{id}', [KuesionerTamController::class, 'destroy'])->name('kuesioner-tam.destroy');
    });

    // Analisis
    Route::prefix('analisis')->group(function () {
        Route::get('/index', [AnalisisController::class, 'index'])->name('analisis.index');
        Route::post('/store/', [AnalisisController::class, 'store'])->name('analisis.store');
        Route::put('/update/{id}', [AnalisisController::class, 'update'])->name('analisis.update');
        Route::delete('/delete/{id}', [AnalisisController::class, 'destroy'])->name('analisis.destroy');
    });

    // Kuesioner Riwayat
    Route::prefix('riwayat')->group(function () {
        Route::get('/index', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::post('/store/', [RiwayatController::class, 'store'])->name('riwayat.store');
        Route::put('/update/{id}', [RiwayatController::class, 'update'])->name('riwayat.update');
        Route::delete('/delete/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
    });

    // Kuesioner Riwayat
    Route::prefix('laporan')->group(function () {
        Route::get('/index', [LaporanController::class, 'index'])->name('laporan.index');

        // Laporan PDF
        Route::get('/pdf-pieces', [LaporanController::class, 'pdfPieces'])->name('laporanPdf.pieces');
        Route::get('/pdf-tam', [LaporanController::class, 'pdfTam'])->name('laporanPdf.tam');
        Route::get('/pdf-gabungan', [LaporanController::class, 'pdfGabungan'])->name('laporanPdf.gabungan');

        // Laporan Excel
        // ROUTE BARU: Unduh Excel Murni HTML-to-Excel Stream
        Route::get('/excel-pieces', [LaporanController::class, 'excelPieces'])->name('laporanExcel.pieces');
        Route::get('/excel-tam', [LaporanController::class, 'excelTam'])->name('laporanExcel.tam');
        Route::get('/excel-gabungan', [LaporanController::class, 'excelGabungan'])->name('laporanExcel.gabungan');
    });
});

require __DIR__ . '/auth.php';
