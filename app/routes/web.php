<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '<h1>Welcome to Management Stock Barang (Inventory Management System)</h1><p>Your full-featured inventory management solution is ready. <a href="/login">Login</a> to access the system.</p>';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
