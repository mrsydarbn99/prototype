@extends('layout.app')

@section('content')
@php
   $i = 1;
@endphp

<div class="container-fluid">
    <!-- Create Button -->
    <div class="mb-3">
        <a href="{{ route('user.create') }}" class="btn btn-success" class="">Create New User</a>
    </div>

    <!-- Table Section -->
    <table id="userTable" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <th>{{ $i++ }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge badge-{{ $user->status == 1 ? 'success' : 'danger' }} alignment-text-center">
                        {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary mr-2">Edit</a>
                        <form action="#" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Confirm Delete?');">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

@endsection

@push('css')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#userTable').DataTable();
        });
    </script>
@endpush
