@extends('layout.app')

@section('content')

<form action="{{ route('user.store') }}" method="POST">
    @csrf
    
    @include('users.form')
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection