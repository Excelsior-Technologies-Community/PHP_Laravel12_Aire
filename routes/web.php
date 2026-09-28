<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('products.index');
});

/*
|--------------------------------------------------------------------------
| Product CSV Export
|--------------------------------------------------------------------------
|
| This MUST be before the resource route so that
| /products/export is not treated as a product ID.
|
*/

Route::get(
    '/products/export',
    [ProductController::class, 'export']
)->name('products.export');

/*
|--------------------------------------------------------------------------
| Bulk Product Actions
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/bulk-delete',
    [ProductController::class, 'bulkDestroy']
)->name('products.bulkDestroy');

Route::post(
    '/products/bulk-status',
    [ProductController::class, 'bulkStatus']
)->name('products.bulkStatus');

/*
|--------------------------------------------------------------------------
| Duplicate Product
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/{product}/duplicate',
    [ProductController::class, 'duplicate']
)->name('products.duplicate');

/*
|--------------------------------------------------------------------------
| Product CRUD
|--------------------------------------------------------------------------
*/

Route::resource(
    'products',
    ProductController::class
);
