@extends('layout.app')

@section('content')
<h2>Welcome, {{ Auth::user()->name }}!</h2>
<p>You are logged in as: {{ Auth::user()->role }}</p>
@endsection