# PHP_Laravel12_Aire

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8%2B-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Status](https://img.shields.io/badge/Status-Learning%20Project-orange)

---

# Overview

This project demonstrates how to build a **Product Management system** using:

* Laravel 12
* Aire Form Builder
* Blade Templates
* Simple CSS UI

The application allows users to:

* Create products
* View product list
* Edit products
* Delete products

---

# Features

* Laravel 12 CRUD application
* Aire Form Builder integration
* Simple Blade layout template
* Form validation
* Model binding with Aire
* Clean UI using CSS
* Resource controller routing

---

---

# Folder Structure

```
aire-crud
│
├── app
│   ├── Http
│   │   └── Controllers
│   │       └── ProductController.php
│   │
│   └── Models
│       └── Product.php
│
├── database
│   └── migrations
│       └── create_products_table.php
│
├── resources
│   └── views
│       ├── layout.blade.php
│       └── products
│           ├── index.blade.php
│           ├── create.blade.php
│           └── edit.blade.php
│
└── routes
    └── web.php
```

---

# 1. Requirements

Make sure the following are installed:

* PHP 8+
* Composer
* MySQL / MariaDB
* Node.js (optional)
* Laravel CLI (optional)

---

# 2. Install Laravel Project

Create a new Laravel project:

```bash
composer create-project laravel/laravel aire-crud
```

Run server:

```bash
php artisan serve
```

Open browser:

```
http://127.0.0.1:8000
```

---

# 3. Install Aire Form Builder

Install the Aire package:

```bash
composer require glhd/aire
```

Publish configuration (optional):

```bash
php artisan vendor:publish --tag=aire-config
```

---

# 4. Database Configuration

Open `.env` file and update database details.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

---

# 5. Create Model and Migration

Run command:

```bash
php artisan make:model Product -m
```

Files created:

```
app/Models/Product.php
database/migrations/xxxx_create_products_table.php
```

---

# 6. Update Migration

Open migration file.

```
database/migrations/create_products_table.php
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

Run migration:

```bash
php artisan migrate
```

---

# 7. Update Product Model

Open:

```
app/Models/Product.php
```

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name',
        'price',
        'description'
    ];

}
```

---

# 8. Create Controller

Generate controller:

```bash
php artisan make:controller ProductController
```

Open:

```
app/Http/Controllers/ProductController.php
```

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    // Display list of all products
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index',compact('products'));
    }

    // Show product create form
    public function create()
    {
        return view('products.create');
    }

    // Store new product in database
    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'price'=>'required'
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
        ->with('success','Product Added Successfully');
    }

    // Show edit form for selected product
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    // Update existing product in database
    public function update(Request $request,Product $product)
    {

        $request->validate([
            'name'=>'required',
            'price'=>'required'
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
        ->with('success','Product Updated');
    }

    // Delete product from database
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
        ->with('success','Product Deleted');
    }

}
```

---

# 9. Add Routes

Open:

```
routes/web.php
```

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Redirect the homepage URL to the products list page
Route::get('/', function () {
    return redirect('/products');
});

// Create all CRUD routes for ProductController (index, create, store, edit, update, destroy)
Route::resource('products', ProductController::class);
```

---

# 10. Create Layout Template

Create:

```
resources/views/layout.blade.php
```

```html
<!DOCTYPE html>
<html>
<head>

<title>Laravel Aire CRUD</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
margin:0;
padding:0;
}

.container{
width:900px;
margin:auto;
background:white;
padding:30px;
margin-top:40px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

h1{
text-align:center;
margin-bottom:20px;
}

.btn{
padding:8px 14px;
border:none;
border-radius:5px;
cursor:pointer;
text-decoration:none;
font-size:14px;
}

.btn-primary{
background:#3490dc;
color:white;
}

.btn-danger{
background:#e3342f;
color:white;
}

.btn-success{
background:#38c172;
color:white;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

table th,table td{
padding:10px;
border-bottom:1px solid #ddd;
text-align:left;
}

input,textarea{
width:100%;
padding:8px;
margin-top:6px;
margin-bottom:12px;
border:1px solid #ccc;
border-radius:5px;
}

.alert{
padding:10px;
background:#38c172;
color:white;
border-radius:5px;
margin-bottom:15px;
}

</style>

</head>

<body>

<div class="container">

<h1>Laravel 12 Aire CRUD</h1>

@if(session('success'))
<div class="alert">
{{ session('success') }}
</div>
@endif

@yield('content')

</div>

</body>
</html>
```

---

# 11. Create Products Views Folder

```
resources/views/products
```

---

# 12. Product List Page

```
resources/views/products/index.blade.php
```

```php
@extends('layout')

@section('content')

<h2>Product List</h2>

<a href="{{ route('products.create') }}" class="btn btn-primary">
Add Product
</a>

<br><br>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Price</th>
<th>Description</th>
<th>Action</th>
</tr>

@foreach($products as $product)

<tr>

<td>{{ $product->id }}</td>

<td>{{ $product->name }}</td>

<td>{{ $product->price }}</td>

<td>{{ $product->description }}</td>

<td>

<a href="{{ route('products.edit',$product->id) }}" class="btn btn-success">
Edit
</a>

<form action="{{ route('products.destroy',$product->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button type="submit" class="btn btn-danger">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</table>

@endsection
```

---

# 13. Create Product Page

```
resources/views/products/create.blade.php
```

```php
@extends('layout')

@section('content')

<h2>Create Product</h2>

{{ Aire::open()->route('products.store') }}

<label>Product Name</label>
{{ Aire::input('name') }}

<label>Price</label>
{{ Aire::number('price') }}

<label>Description</label>
{{ Aire::textarea('description') }}

{{ Aire::submit('Save Product')->addClass('btn btn-primary') }}

{{ Aire::close() }}

@endsection
```

---

# 14. Edit Product Page

```
resources/views/products/edit.blade.php
```

```php
@extends('layout')

@section('content')

<h2>Edit Product</h2>

{{ Aire::open()
->route('products.update',$product->id)
->method('PUT')
->bind($product)
}}

<label>Product Name</label>
{{ Aire::input('name') }}

<label>Price</label>
{{ Aire::number('price') }}

<label>Description</label>
{{ Aire::textarea('description') }}

{{ Aire::submit('Update Product')->addClass('btn btn-success') }}

{{ Aire::close() }}

@endsection
```

---

# 15. Run the Project

Start server:

```bash
php artisan serve
```

Open:

```
http://127.0.0.1:8000/products
```
INDEX:

<img width="958" height="439" alt="Screenshot 2026-03-06 122849" src="https://github.com/user-attachments/assets/596466f7-8b55-45b9-a3c5-35c071f25fcc" />

---
CREATE:

<img width="960" height="491" alt="Screenshot 2026-03-06 120107" src="https://github.com/user-attachments/assets/1c616f11-2c17-4154-b1e0-5833a1eb8017" />

<img width="962" height="390" alt="Screenshot 2026-03-06 120118" src="https://github.com/user-attachments/assets/4a6ca9c8-5a37-421d-9d30-ea9f39f2898c" />

---
EDIT:

<img width="955" height="490" alt="Screenshot 2026-03-06 120156" src="https://github.com/user-attachments/assets/37b2e917-348b-439c-8a7b-f731eef362de" />

<img width="958" height="391" alt="Screenshot 2026-03-06 120206" src="https://github.com/user-attachments/assets/7d10dcd6-ea93-4ce7-9589-e71fff38f6ff" />

---
DELETE:

<img width="962" height="338" alt="Screenshot 2026-03-06 122756" src="https://github.com/user-attachments/assets/0d8bd9cc-4548-4612-8f28-d5cdcd9eac9e" />

---

# 16. Aire Methods Used

```
Aire::open()
Aire::input()
Aire::number()
Aire::textarea()
Aire::submit()
Aire::close()
```

These replace normal HTML forms and simplify Laravel form development.

---


