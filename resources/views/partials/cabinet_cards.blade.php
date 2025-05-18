<div class="row">
  @forelse ($cabinets as $cabinet)
    <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
      <div class="card h-100 d-flex flex-column shadow-sm 
        {{ $cabinet->is_occupied === 1 ? 'bg-danger-subtle' : 'bg-success-subtle' }}">
        <div class="card-body flex-grow-1 p-2">
          <h4 class="text-center text-black bg-white p-1 rounded">{{ $cabinet->cabinet_no }}</h4>
          <p class="card-text mt-2 mb-1">
            <strong>Status:</strong>
            <span class="{{ $cabinet->is_occupied === 1 ? 'text-danger' : 'text-success' }}">
              {{ $cabinet->is_occupied === 1 ? 'Occupied' : 'Available' }}
            </span>
          </p>
          <p class="card-text mb-2">
            <strong>Barcode:</strong> {{ $cabinet->barcode ?? 'N/A' }}
          </p>
        </div>
        <div class="card-footer bg-transparent border-0 mt-auto">
          @if ($cabinet->is_occupied)
           <button type="button"
                    class="btn btn-sm btn-outline-danger w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmCheckoutModal"
                    data-cabinet-id="{{ $cabinet->id }}"
                    data-cabinet-no="{{ $cabinet->cabinet_no }}">
                Check Out
            </button>
          @else
            <button type="button"
                    class="btn btn-sm btn-outline-success w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#checkinModal"
                    data-cabinet-id="{{ $cabinet->id }}"
                    data-cabinet-no="{{ $cabinet->cabinet_no }}">
                Check In
            </button>
          @endif
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <p>No cabinets found.</p>
    </div>
  @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
  {{ $cabinets->links('pagination::bootstrap-4') }}
</div>
