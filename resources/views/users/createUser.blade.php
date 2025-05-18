@extends('layout.app')

@section('content')
<div class="container my-4">
    <h4>Create User</h4>
    <hr>
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        
        @include('users.form')
        
        <a class="btn btn-secondary" href="{{ route('userlist') }}">Back</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection