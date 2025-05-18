@extends('layout.app')

@section('content')
<div class="container my-4">
    <h4>Edit User</h4>
    <hr>
    <form action="{{ route('user.update',$model->id) }}" method="POST">
        @csrf
        @method('put')
        @include('users.form')
        
        <a class="btn btn-secondary" href="{{ route('userlist') }}">Back</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection