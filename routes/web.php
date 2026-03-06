<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Redirect the homepage URL to the products list page
Route::get('/', function () {
    return redirect('/products');
});

// Create all CRUD routes for ProductController (index, create, store, edit, update, destroy)
Route::resource('products', ProductController::class);