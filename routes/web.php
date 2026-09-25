<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Redirect homepage to product management
Route::get('/', function () {
    return redirect()->route('products.index');
});

// Product CRUD routes
Route::resource('products', ProductController::class);