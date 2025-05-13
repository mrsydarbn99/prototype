@extends('layout.app')

@section('content')
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
@endsection

@push('css')
<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.3.0/r-3.0.4/datatables.min.css" rel="stylesheet" integrity="sha384-hvvl0zqyiz/OoB9pqvIz3WTbZiBxCKCPw655pPTCo9fz0/VkKDuapOt98qGx+swQ" crossorigin="anonymous">

@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>    
<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.3.0/r-3.0.4/datatables.min.js" integrity="sha384-zLKbcB25JymfSm/5rheU686M8zQ0V/jOSq3k1y1Cp6YuSMBlAknpASwFmCDCk6QT" crossorigin="anonymous"></script>


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
                        return `<span class="badge bg-${badge}">${label}</span>`;
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
