<?php

use App\Http\Controllers\AuthC;
use App\Http\Controllers\UserC;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthC::class, 'login']);

Route::post('/logout', [AuthC::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin', function () {
        return view('dash');
    })->name('dashboard.admin');
});

Route::middleware(['auth', 'role:employee'])->group(function () {

    Route::get('/petugas', function () {
        return view('dashboard.petugas');
    })->name('dashboard.petugas');
});

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/peminjam', function () {
        return view('dashboard.peminjam');
    })->name('dashboard.peminjam');
});

Route::prefix('users-management/tabel')->name('users.')->group(function () {
    Route::get('/', [UserC::class, 'index'])->name('index');
    Route::get('/create', [UserC::class, 'create'])->name('form');
    Route::post('/store', [UserC::class, 'store'])->name('store');
    Route::get('/view/{id}', [UserC::class, 'view'])->name('view');
    Route::put('/update/{id}', [UserC::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [UserC::class, 'delete'])->name('delete');
});

Route::prefix('management-alat/tabel')->name('alat.')->group(function () {
    Route::get('/', [UserC::class, 'index'])->name('index');
    Route::get('/create', [UserC::class, 'create'])->name('form');
    Route::post('/store', [UserC::class, 'store'])->name('store');
    Route::get('/view/{id}', [UserC::class, 'view'])->name('view');
    Route::put('/update/{id}', [UserC::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [UserC::class, 'delete'])->name('delete');
});
