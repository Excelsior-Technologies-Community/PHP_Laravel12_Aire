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
| Form Studio & Dynamic Custom Fields Configurator
|--------------------------------------------------------------------------
*/

Route::get(
    '/products/form-studio',
    [ProductController::class, 'formStudio']
)->name('products.formStudio');

Route::post(
    '/products/form-studio/save',
    [ProductController::class, 'saveSchema']
)->name('products.saveSchema');


/*
|--------------------------------------------------------------------------
| Image Gallery Studio & Product Variant Matrix
|--------------------------------------------------------------------------
*/

Route::get(
    '/products/variant-matrix',
    [ProductController::class, 'variantMatrix']
)->name('products.variantMatrix');

Route::post(
    '/products/variant-matrix/generate',
    [ProductController::class, 'generateVariants']
)->name('products.generateVariants');


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
