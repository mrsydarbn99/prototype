@extends('layout.app')

@section('content')
<div class="container my-4">
    <h4>Edit User</h4>
    <hr>
    <form action="{{ route('profile.update',$user->id) }}" method="POST">
        @csrf
        @method('put')
        @include('users.form')
        
        <a class="btn btn-secondary" href="{{ route('dashboard') }}">Back</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection