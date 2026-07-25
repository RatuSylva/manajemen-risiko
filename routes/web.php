<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ReviuController;
use App\Http\Controllers\RiwayatRisikoController;
use App\Http\Controllers\RisikoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [
    AuthController::class,
    'login',
])->name('login.process');

Route::post('/logout', [
    AuthController::class,
    'logout',
])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Menu yang dapat diakses semua pengguna
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Riwayat Risiko
    |--------------------------------------------------------------------------
    */

    Route::get('/riwayat-risiko', [
        RiwayatRisikoController::class,
        'index',
    ])->name('riwayat.index');

    Route::get('/riwayat-risiko/{risiko}', [
        RiwayatRisikoController::class,
        'show',
    ])->name('riwayat.show');

    /*
    |--------------------------------------------------------------------------
    | Laporan Risiko
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan', [
        LaporanController::class,
        'index',
    ])->name('laporan.index');

    Route::get('/laporan/download', [
        LaporanController::class,
        'download',
    ])->name('laporan.download');
});

/*
|--------------------------------------------------------------------------
| UPR - Unit Pemilik Risiko
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:UPR',
])->group(function () {

    Route::get('/upr', [
        DashboardController::class,
        'upr',
    ])->name('upr.dashboard');

    Route::resource(
        'risiko',
        RisikoController::class
    )->except([
        'show',
    ]);
});

/*
|--------------------------------------------------------------------------
| UMR - Unit Manajemen Risiko
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:UMR',
])->group(function () {

    Route::get('/umr', [
        DashboardController::class,
        'umr',
    ])->name('umr.dashboard');

    Route::get('/verifikasi', [
        VerifikasiController::class,
        'index',
    ])->name('verifikasi.index');

    Route::put('/verifikasi/{risiko}', [
        VerifikasiController::class,
        'update',
    ])->name('verifikasi.update');
});

/*
|--------------------------------------------------------------------------
| UPI - Unit Pengawas Intern
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:UPI',
])->group(function () {

    Route::get('/upi', [
        DashboardController::class,
        'upi',
    ])->name('upi.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Reviu Risiko
    |--------------------------------------------------------------------------
    */

    Route::get('/reviu', [
        ReviuController::class,
        'index',
    ])->name('reviu.index');

    Route::put('/reviu/{risiko}', [
        ReviuController::class,
        'update',
    ])->name('reviu.update');

    /*
    |--------------------------------------------------------------------------
    | Pengelolaan Pengguna
    |--------------------------------------------------------------------------
    */

    Route::get('/users', [
        UserController::class,
        'index',
    ])->name('users.index');

    Route::get('/users/create', [
        UserController::class,
        'create',
    ])->name('users.create');

    Route::post('/users', [
        UserController::class,
        'store',
    ])->name('users.store');

    Route::get('/users/{user}/edit', [
        UserController::class,
        'edit',
    ])->name('users.edit');

    Route::put('/users/{user}', [
        UserController::class,
        'update',
    ])->name('users.update');

    Route::patch('/users/{user}/toggle-status', [
        UserController::class,
        'toggleStatus',
    ])->name('users.toggle-status');
});