@extends('layout.app')

@section('content')
<div class="container my-4">
    <h4>Parcel List</h4>
    <hr>
    <table id="transactionsTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Cabinet No</th>
                <th>Location</th>
                <th>Barcode</th>
                <th>Action</th>
                <th>Date & Time</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
@endpush

@push('js')
<!-- jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>



<script>
$(document).ready(function() {
    $('#transactionsTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: "{{ route('parcels.data') }}",
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
            { data: 'user_name' },
            { data: 'cabinet_no' },
            { data: 'location' },
            { data: 'barcode' },
            { 
                data: 'action',
                render: function (data, type, row) {
                    let badge = data == 'check-in' ? 'success' : 'danger';
                    let label = data == 'check-in' ? 'Check In' : 'Check Out';
                    return `<div style="text-align: center;">
                                <span class="badge bg-${badge}">${label}</span>
                            </div>`;
                }

            },
            { data: 'created_at' }
        ],
    });
});
</script>
@endpush
