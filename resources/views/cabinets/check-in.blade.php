@extends('layout.app')
@section('content')
<div class="container">
    <h1>Check In Item</h1>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <form action="{{ route('cabinets.check-in') }}" method="POST">
        @csrf
        
        <div class="form-group mb-3">
            <label for="barcode">Item Barcode</label>
            <input type="text" class="form-control" id="barcode" name="barcode" required autofocus>
        </div>
        
        <div class="form-group mb-3">
            <label for="cabinet_number">Cabinet Number</label>
            <select class="form-control" id="cabinet_number" name="cabinet_number" required>
                <option value="">Select a cabinet</option>
                @foreach($availableCabinets as $cabinet)
                    <option value="{{ $cabinet->cabinet_number }}">Cabinet #{{ $cabinet->cabinet_number }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label for="notes">Notes (Optional)</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Check In</button>
        <a href="{{ route('cabinets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
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
                document.getElementById('cabinet_number').focus();
            }
        });
    });
</script>
@endsection