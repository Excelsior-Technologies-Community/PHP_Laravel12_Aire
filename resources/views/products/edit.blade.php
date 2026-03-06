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