<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Simple test route
Route::get('/simple-test', function () {
    return '<h1>Simple Test Route Working</h1><p>If you see this, the routes file is loading.</p>';
});

// Main custom landing page
Route::get('/', function () {
    return '<h1>Welcome to Management Stock Barang (Inventory Management System)</h1>' .
        '<p>Your full-featured inventory management solution is ready. <a href="/login">Login</a> to access the system.</p>';
});

// Authentication routes (Laravel UI or Breeze must be installed)
Auth::routes();

// Home after login
Route::get('/home', [HomeController::class, 'index'])->name('home');
