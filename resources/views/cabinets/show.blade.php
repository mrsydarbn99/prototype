@extends('layout.app')
@section('content')
<div class="container">
    <h1>Cabinet #{{ $cabinet->cabinet_number }}</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Status: {{ ucfirst($cabinet->status) }}</h5>
            @if($cabinet->status == 'occupied')
                <p>Barcode: {{ $cabinet->barcode }}</p>
            @endif
            <p>{{ $cabinet->description }}</p>
        </div>
    </div>
    
    <h2>Recent Transactions</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
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
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $transaction->action)) }}</td>
                    <td>{{ $transaction->barcode }}</td>
                    <td>{{ $transaction->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <a href="{{ route('cabinets.index') }}" class="btn btn-secondary">Back to Cabinets</a>
</div>
@endsection