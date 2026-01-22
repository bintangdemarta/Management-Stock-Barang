<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '<h1>Welcome to Management Stock Barang (Inventory Management System)</h1><p>Your full-featured inventory management solution is ready. <a href="/login">Login</a> to access the system.</p>';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('items', \App\Http\Controllers\ItemController::class);
    Route::resource('warehouses', \App\Http\Controllers\WarehouseController::class);
    Route::resource('locations', \App\Http\Controllers\LocationController::class);
    Route::resource('transactions', \App\Http\Controllers\StockTransactionController::class)->only(['index', 'create', 'store', 'show']);
});
