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