@extends('layout.app')

@section('content')

<form action="{{ route('resident-update',$model->id) }}" method="POST">
    @csrf
    @method('put')
    @include('residents.form')
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection