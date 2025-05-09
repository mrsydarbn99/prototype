@extends('layout.app')
@section('content')
<div class="container">
    <h1>Cabinet Management System</h1>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="{{ route('cabinets.check-in.form') }}" class="btn btn-primary">Check In Item</a>
            <a href="{{ route('cabinets.check-out.form') }}" class="btn btn-secondary">Check Out Item</a>
            <a href="{{ route('cabinets.transactions') }}" class="btn btn-info">Transaction History</a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="row">
        @foreach($cabinets as $cabinet)
            <div class="col-md-2 mb-4">
                <div class="card {{ $cabinet->status == 'occupied' ? 'bg-danger text-white' : 'bg-success text-white' }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">Cabinet #{{ $cabinet->cabinet_number }}</h5>
                        <p class="card-text">{{ ucfirst($cabinet->status) }}</p>
                        @if($cabinet->status == 'occupied')
                            <p class="card-text">Barcode: {{ $cabinet->barcode }}</p>
                        @endif
                        <a href="{{ route('cabinets.show', $cabinet) }}" class="btn btn-sm btn-light">Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection