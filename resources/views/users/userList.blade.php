@extends('layout.app')

@section('content')
<div class="container my-4">
    <h4>User List</h4>
    <hr>
    <div class="mb-3">
        <a href="{{ route('user.create') }}" class="btn btn-success">Create New User</a>
    </div>

    <table id="userTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th style="width: 3%;">#</th>
                <th style="width: 40%;">Name</th>
                <th style="width: 40%;">Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            processing: true,
            serverSide: false,
            ajax: '{{ route('user.data') }}',
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                    return meta.row + 1;
                    },
                    searchable: false,
                    orderable: false,
                    title: '#'
                },
                { data: 'name' },
                { data: 'email' },
                {
                    data: 'status',
                    render: function (data, type, row) {
                        let badge = data == 1 ? 'success' : 'danger';
                        let label = data == 1 ? 'Active' : 'Inactive';
                        return `<div style="text-align: center;">
                                    <span class="badge bg-${badge}">${label}</span>
                                </div>`;
                    }
                },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `<div style="text-align: center;">
                                    <a href="/user/${data}/edit" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="/user/${data}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this user?')" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>`;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush
