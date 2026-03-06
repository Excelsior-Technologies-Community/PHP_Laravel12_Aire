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