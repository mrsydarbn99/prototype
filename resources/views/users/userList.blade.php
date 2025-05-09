@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('user.create') }}" class="btn btn-success">Create New User</a>
    </div>

    <table id="userTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> 
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap4.css"> 

@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>    
<script src=" https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>    
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>    
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap4.js"></script>    

<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            processing: true,
            ajax: '{{ route('user.data') }}',
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                {
                    data: 'status',
                    render: function (data, type, row) {
                        let badge = data == 1 ? 'success' : 'danger';
                        let label = data == 1 ? 'Active' : 'Inactive';
                        return `<span class="badge badge-${badge}">${label}</span>`;
                    }
                },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            <a href="/user/${data}/edit" class="btn btn-sm btn-primary">Edit</a>
                            <form action="/user/${data}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this user?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>`;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush
