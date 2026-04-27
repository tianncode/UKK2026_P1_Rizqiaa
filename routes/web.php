<?php

use App\Http\Controllers\ActivityLogC;
use App\Http\Controllers\AuthC;
use App\Http\Controllers\CategoriesC;
use App\Http\Controllers\LoansC;
use App\Http\Controllers\ReportC;
use App\Http\Controllers\ReturnC;
use App\Http\Controllers\ToolsC;
use App\Http\Controllers\UnitConditionsC;
use App\Http\Controllers\UnitsC;
use App\Http\Controllers\UserC;
use App\Models\Tools;
use App\Models\UnitConditions;
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

Route::middleware(['auth'])->group(function () {

    Route::get('/admin', function () {
        $singleTools = Tools::where('item_type', 'single')->get();
        return view('dash', compact('singleTools'));
    })->middleware('role:admin')->name('dashboard.admin');

    Route::get('/petugas', function () {
        return view('dashboard.petugas');
    })->middleware('role:employee')->name('dashboard.petugas');

    Route::get('/peminjam', function () {
        return view('dashboard.peminjam');
    })->middleware('role:user')->name('dashboard.peminjam');
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
    Route::get('/detail/{id}', [ToolsC::class, 'detail'])->name('detail');
    Route::put('/update/{id}', [ToolsC::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ToolsC::class, 'delete'])->name('delete');
    Route::post('/tool-units/store', [UnitsC::class, 'store'])->name('units-store');
    Route::put('/tool-units/update/{id}', [UnitsC::class, 'update'])->name('units-update');
    Route::delete('/tool-units/delete/{id}', [UnitsC::class, 'delete'])->name('units-delete');
    Route::post('/unit-conditions', [UnitConditionsC::class, 'store'])->name('unit-conditions.store');
    Route::delete('/unit-conditions/{id}', [UnitConditionsC::class, 'delete'])->name('unit-conditions.delete');
    Route::get('/tools/{tool}/check-availability', [ToolsC::class, 'checkAvailability'])
        ->name('check-availability');
});


Route::get('/daftar-alat', [ToolsC::class, 'daftar'])->name('tools.daftar');

Route::prefix('management-loans')->name('loans.')->group(function () {
    Route::get('/', [LoansC::class, 'index'])->name('index');
    Route::get('/create/{toolId}', [LoansC::class, 'create'])->name('form');
    Route::post('/store', [LoansC::class, 'store'])->name('store');
    Route::get('/view/{id}', [LoansC::class, 'view'])->name('view');
    Route::get('/monitoring', [LoansC::class, 'monitoring'])->name('monitoring');
    Route::get('/show', [LoansC::class, 'show'])->name('show');
    Route::post('/{id}/approve', [LoansC::class, 'approve'])->name('monitoring.approve');
    Route::post('/{id}/reject', [LoansC::class, 'reject'])->name('monitoring.reject');
    Route::get('/history', [LoansC::class, 'history'])->name('history');
});

Route::prefix('management-return')->name('return.')->group(function () {
    Route::get('/monitoring', [ReturnC::class, 'index'])->name('index');
    Route::post('/store', [ReturnC::class, 'store'])->name('store');
    Route::get('/show', [ReturnC::class, 'show'])->name('show');
    Route::post('/{loan}/process', [ReturnC::class, 'process'])->name('process');
    Route::put('/{return}/verify', [ReturnC::class, 'verify'])->name('verify');
});

Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [ReportC::class, 'index'])->name('index');
    Route::get('/export/{type}', [ReportC::class, 'export'])->name('export');

    Route::get('/loans',      fn() => redirect()->route('reports.index', ['tab' => 'loans']));
    Route::get('/returns',    fn() => redirect()->route('reports.index', ['tab' => 'returns']));
    Route::get('/violations', fn() => redirect()->route('reports.index', ['tab' => 'violations']));
    Route::get('/users',      fn() => redirect()->route('reports.index', ['tab' => 'users']));
});

Route::get('/activity-logs', [ActivityLogC::class, 'index'])->name('activity-logs.index');
