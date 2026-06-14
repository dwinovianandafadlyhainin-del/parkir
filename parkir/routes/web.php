<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\TransactionController;

Route::get('/', fn() => redirect()->route('transaction.index'));

// Location
Route::get('/location', [LocationController::class, 'index'])->name('location.index');
Route::get('/location/create', [LocationController::class, 'create'])->name('location.create');
Route::post('/location', [LocationController::class, 'store'])->name('location.store');
Route::get('/location/{location}/edit', [LocationController::class, 'edit'])->name('location.edit');
Route::put('/location/{location}', [LocationController::class, 'update'])->name('location.update');

// Vehicle Type
Route::get('/vehicle-type', [VehicleTypeController::class, 'index'])->name('vehicle-type.index');
Route::get('/vehicle-type/create', [VehicleTypeController::class, 'create'])->name('vehicle-type.create');
Route::post('/vehicle-type', [VehicleTypeController::class, 'store'])->name('vehicle-type.store');
Route::get('/vehicle-type/{vehicleType}/edit', [VehicleTypeController::class, 'edit'])->name('vehicle-type.edit');
Route::put('/vehicle-type/{vehicleType}', [VehicleTypeController::class, 'update'])->name('vehicle-type.update');

// Transaction
Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
Route::post('/transaction/enter', [TransactionController::class, 'enter'])->name('transaction.enter');
Route::post('/transaction/exit', [TransactionController::class, 'exit'])->name('transaction.exit');
Route::get('/transaction/all', [TransactionController::class, 'allTransactions'])->name('transaction.all');
Route::get('/transaction/pdf/{id}', [TransactionController::class, 'viewPdf'])->name('transaction.pdf');
Route::get('/transaction/get-ticket', [TransactionController::class, 'getTicketByNumber'])->name('transaction.get-ticket');

// Reports
Route::get('/report/location', [TransactionController::class, 'locationReport'])->name('report.location');
Route::get('/report/transaction', [TransactionController::class, 'transactionReport'])->name('report.transaction');

// Fake auth routes (sign out just redirects home)
Route::get('/logout', fn() => redirect()->route('transaction.index'))->name('logout');
