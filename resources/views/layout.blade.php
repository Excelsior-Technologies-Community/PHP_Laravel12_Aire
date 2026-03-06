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