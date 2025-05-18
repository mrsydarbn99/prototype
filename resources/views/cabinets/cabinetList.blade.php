@extends('layout.app')

@section('content')
<div class="container my-4">

  <!-- Your Parcel Section -->
  @if(!$userParcels->isEmpty())
    <h4>Your Parcel</h4>
    <hr>
    <div class="position-relative my-4">
        <!-- Left Button (Outside Left) -->
        <button class="carousel-control-prev position-absolute top-50 translate-middle-y bg-black text-white rounded-circle d-flex align-items-center justify-content-center"
                type="button"
                data-bs-target="#userParcelCarousel"
                data-bs-slide="prev"
                style="left: -60px; z-index: 10; width: 40px; height: 40px;">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <!-- Carousel Wrapper -->
        <div id="userParcelCarousel" class="carousel slide">
            <div class="carousel-inner">
            @foreach ($userParcels->chunk(6) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                <div class="row justify-content-center">
                    @foreach ($chunk as $cabinet)
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
                    @endforeach
                </div>
                </div>
            @endforeach
            </div>
        </div>

        <!-- Right Button (Outside Right) -->
        <button class="carousel-control-next position-absolute top-50 translate-middle-y bg-black text-white rounded-circle d-flex align-items-center justify-content-center"
                type="button"
                data-bs-target="#userParcelCarousel"
                data-bs-slide="next"
                style="right: -60px; z-index: 10; width: 40px; height: 40px;">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

  @endif

  <!-- Cabinet List Section -->
  <h4>Cabinet List</h4>
  <hr>

  <!-- Search Bar -->
  <div class="mb-4">
    <div class="d-flex align-items-center gap-2">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by Cabinet No or Barcode" style="border-radius: 0.375rem;">
        
        <select id="typeSelect" class="form-select" aria-label="Select Type" style="border-radius: 0.375rem;">
        <option value="">All Types</option>
        @foreach ($refTypes as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
        </select>

        <select id="locationSelect" class="form-select" aria-label="Select Location" style="border-radius: 0.375rem;">
        <option value="">All Locations</option>
        @foreach ($refLocations as $location)
            <option value="{{ $location->id }}">{{ $location->name }}</option>
        @endforeach
        </select>

        <button type="button" id="resetBtn" class="btn btn-outline-secondary" style="border-radius: 0.375rem;">Reset</button>
    </div>
  </div>




  <!-- AJAX Target Container -->
  <div id="cabinetContainer">
    @include('partials.cabinet_cards', ['cabinets' => $cabinets])
  </div>
</div>

<!-- Checkout Confirmation Modal -->
<div class="modal fade" id="confirmCheckoutModal" tabindex="-1" aria-labelledby="confirmCheckoutLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="checkoutForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="confirmCheckoutLabel">Confirm Check Out</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to check out <strong id="cabinetLabel"></strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Check Out</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Check-In Modal -->
<div class="modal fade" id="checkinModal" tabindex="-1" aria-labelledby="checkinModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="checkinForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="checkinModalLabel">Check In Cabinet</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="cabinet_id" id="checkinCabinetId" />
          <div class="mb-3">
            <label for="barcodeInput" class="form-label">Enter Barcode</label>
            <input type="text" class="form-control" id="barcodeInput" name="barcode" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Check In</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('js')
<script>
let debounceTimeout = null;
let currentSearch = '';
let currentType = '';
let currentLocation = '';

function fetchCabinets(page = 1, search = '', type = '', location = '') {
  $.ajax({
    url: "{{ route('cabinet.search') }}",
    type: 'GET',
    data: { 
      page: page, 
      search: search,
      type: type,
      location: location
    },
    beforeSend: function () {
      $('#cabinetContainer').html('<div class="text-center">Loading...</div>');
    },
    success: function (data) {
      $('#cabinetContainer').html(data.html);
    },
    error: function (xhr) {
      console.error('AJAX Error:', xhr);
    }
  });
}

$(document).ready(function () {
  // Debounced Search for text input
  $('#searchInput').on('input', function () {
    clearTimeout(debounceTimeout);
    currentSearch = $(this).val();
    debounceTimeout = setTimeout(() => fetchCabinets(1, currentSearch, currentType, currentLocation), 300);
  });

  // Change event for Type select
  $('#typeSelect').on('change', function () {
    currentType = $(this).val();
    fetchCabinets(1, currentSearch, currentType, currentLocation);
  });

  // Change event for Location select
  $('#locationSelect').on('change', function () {
    currentLocation = $(this).val();
    fetchCabinets(1, currentSearch, currentType, currentLocation);
  });

  // Reset Button - clear all filters
  $('#resetBtn').click(function () {
    $('#searchInput').val('');
    $('#typeSelect').val('');
    $('#locationSelect').val('');
    currentSearch = '';
    currentType = '';
    currentLocation = '';
    fetchCabinets(1);
  });

  // Pagination links
  $(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    const page = $(this).attr('href').split('page=')[1];
    fetchCabinets(page, currentSearch, currentType, currentLocation);
  });
});

$('#confirmCheckoutModal').on('show.bs.modal', function (event) {
  const button = $(event.relatedTarget);
  const cabinetId = button.data('cabinet-id');
  const cabinetNo = button.data('cabinet-no');

  const form = $('#checkoutForm');
  const label = $('#cabinetLabel');

  // Update label in modal
  label.text(`cabinet ${cabinetNo}`);

  // Update form action
  const action = "{{ route('cabinet.checkoutOne', ['cabinet' => '__id__']) }}".replace('__id__', cabinetId);
  form.attr('action', action);
});

$('#checkinModal').on('show.bs.modal', function (event) {
  const button = $(event.relatedTarget);
  const cabinetId = button.data('cabinet-id');
  const cabinetNo = button.data('cabinet-no');

  $('#checkinCabinetId').val(cabinetId);
  $('#barcodeInput').val('');
});

$('#checkinForm').submit(function(e) {
  e.preventDefault();

  const cabinetId = $('#checkinCabinetId').val();
  const barcode = $('#barcodeInput').val();
  const token = $('input[name="_token"]').val();

  $.ajax({
    url: `/cabinet/checkin/${cabinetId}`,
    type: 'POST',
    data: { barcode: barcode, _token: token },
    success: function(response) {
      $('#checkinModal').modal('hide');
      window.location.reload();
    },
    error: function(xhr) {
      alert('Error during check-in. Please try again.');
      console.error(xhr.responseText);
    }
  });
});
</script>
@endpush
