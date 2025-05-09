@extends('layout.app')
@section('content')
<div class="container">
    <h1>Transaction History</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Cabinet #</th>
                <th>User</th>
                <th>Action</th>
                <th>Barcode</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $transaction->cabinet->cabinet_number }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $transaction->action)) }}</td>
                    <td>{{ $transaction->barcode }}</td>
                    <td>{{ $transaction->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $transactions->links() }}
    
    <a href="{{ route('cabinets.index') }}" class="btn btn-secondary">Back to Cabinets</a>
</div>
@endsection