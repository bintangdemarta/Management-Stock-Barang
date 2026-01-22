<?php

use Illuminate\Support\Facades\Route;

// Simple test route
Route::get('/simple-test', function () {
    return '<h1>Simple Test Route Working</h1><p>If you see this, the routes file is loading.</p>';
});

// Main route
Route::get('/', function () {
    return '<h1>Welcome to Management Stock Barang (Inventory Management System)</h1><p>Your full-featured inventory management solution is ready. <a href="/login">Login</a> to access the system.</p>';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');