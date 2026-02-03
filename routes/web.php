<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\usermanagement\UserController;
use App\Http\Controllers\pages\workprogress\WorkProgressController;
use App\Http\Controllers\pages\workprogress\WorkMonitoringController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('content.pages.pages-home');
// });

Route::get('/', [HomePage::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('user-management')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('usermanagement.index');
    Route::get('/datatable', [UserController::class, 'datatable'])->name('usermanagement.datatable');
    Route::get('/{id}', [UserController::class, 'show'])->name('usermanagement.show');
    Route::post('/{id}', [UserController::class, 'update'])->name('usermanagement.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('usermanagement.destroy');
    Route::post('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('usermanagement.resetpassword');
});

Route::middleware('auth')->prefix('work-progress')->group(function () {
    Route::get('/', [WorkProgressController::class, 'index'])->name('workprogress.index');
    Route::get('/datatable', [WorkProgressController::class, 'datatable'])->name('workprogress.datatable');
    Route::post('/', [WorkProgressController::class, 'store'])->name('workprogress.store');
    Route::get('/{id}', [WorkProgressController::class, 'show'])->name('workprogress.show');
    Route::post('/{id}', [WorkProgressController::class, 'update'])->name('workprogress.update');
    Route::get('/approval/get/{header}', [WorkProgressController::class, 'editApproval'])->name('workprogress.editapproval');
    Route::post('/approval/store', [WorkProgressController::class, 'storeApproval'])->name('workprogress.storeapproval');
});

Route::middleware('auth')->prefix('work-monitoring')->group(function () {
    Route::get('/', [WorkMonitoringController::class, 'index'])->name('workmonitoring.index');
    Route::get('/datatable', [WorkMonitoringController::class, 'datatable'])->name('workmonitoring.datatable');
    // export excel monitoring
    Route::get('/export-excel', [WorkMonitoringController::class, 'exportExcel'])->name('export.excel');
});

Route::get('/admin', fn() => view('admin'))
    ->middleware('role:admin');

require __DIR__.'/auth.php';
