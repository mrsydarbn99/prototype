@extends('layout.app')
@section('content')
<div class="container">
    <h1>Check Out Item</h1>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <form action="{{ route('cabinets.check-out') }}" method="POST">
        @csrf
        
        <div class="form-group mb-3">
            <label for="barcode">Item Barcode</label>
            <input type="text" class="form-control" id="barcode" name="barcode" required autofocus>
        </div>
        
        <div class="form-group mb-3">
            <label for="notes">Notes (Optional)</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Check Out</button>
        <a href="{{ route('cabinets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
    
    <div class="mt-4">
        <h3>Currently Occupied Cabinets</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Cabinet Number</th>
                    <th>Barcode</th>
                </tr>
            </thead>
            <tbody>
                @foreach($occupiedCabinets as $cabinet)
                    <tr>
                        <td>{{ $cabinet->cabinet_number }}</td>
                        <td>{{ $cabinet->barcode }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barcodeInput = document.getElementById('barcode');
        barcodeInput.focus();
        
        // You can add barcode scanner integration here
        // This assumes the scanner acts as a keyboard input
        barcodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('notes').focus();
            }
        });
    });
</script>
@endsection