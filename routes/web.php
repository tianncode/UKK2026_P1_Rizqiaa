<?php

use App\Http\Controllers\AuthC;
use App\Http\Controllers\CategoriesC;
use App\Http\Controllers\ToolsC;
use App\Http\Controllers\UnitsC;
use App\Http\Controllers\UserC;
use App\Models\Tools;
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
        $singleTools = Tools::where('item_type', 'single')->get();
        return view('dash', compact('singleTools'));
    })->name('dashboard.admin');

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

    Route::prefix('management-categories/tabel')->name('categories.')->group(function () {
        Route::get('/', [CategoriesC::class, 'index'])->name('index');
        Route::get('/create', [CategoriesC::class, 'create'])->name('form');
        Route::post('/store', [CategoriesC::class, 'store'])->name('store');
        Route::get('/view/{id}', [CategoriesC::class, 'view'])->name('view');
        Route::put('/update/{id}', [CategoriesC::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CategoriesC::class, 'delete'])->name('delete');
    });

    Route::prefix('management-alat/tabel')->name('tools.')->group(function () {
        Route::get('/', [ToolsC::class, 'index'])->name('index');
        Route::get('/create', [ToolsC::class, 'create'])->name('form');
        Route::post('/store', [ToolsC::class, 'store'])->name('store');
        Route::get('/view/{id}', [ToolsC::class, 'view'])->name('view');
        Route::put('/update/{id}', [ToolsC::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ToolsC::class, 'delete'])->name('delete');
        Route::post('/tool-units/store', [UnitsC::class, 'store'])->name('units-store');
        Route::put('/tool-units/update/{id}', [UnitsC::class, 'update'])->name('units-update');
        Route::delete('/tool-units/delete/{id}', [UnitsC::class, 'delete'])->name('units-delete');
    });
});
