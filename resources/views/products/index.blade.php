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