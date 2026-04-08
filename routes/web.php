<?php

use App\Http\Controllers\AuthC;
use App\Http\Controllers\PetugasC;
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

Route::prefix('users-management/petugas')->name('petugas.')->group(function () {
    Route::get('/', [PetugasC::class, 'index'])->name('index');
    Route::get('/create', [PetugasC::class, 'create'])->name('form');
    Route::post('/store', [PetugasC::class, 'store'])->name('store');
    Route::get('/view/{id}', [PetugasC::class, 'view'])->name('view');
    Route::put('/update/{id}', [PetugasC::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PetugasC::class, 'delete'])->name('delete'); // <- hapus 'petugas/'
});
