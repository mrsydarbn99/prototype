@extends('layout.app')

@section('content')
<div class="container my-4">

  <!-- User Parcel Section -->
  <div id="userParcelSection">
    @if(!$userParcels->isEmpty())
      @include('partials.cabinet_user_parcel', ['userParcels' => $userParcels])
    @endif
  </div>

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

<!-- Check-In Confirmation Modal -->
<div class="modal fade" id="confirmCheckinModal" tabindex="-1" aria-labelledby="confirmCheckinLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="confirmCheckinForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="confirmCheckinLabel">Confirm Check In</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to check in to <strong id="checkinCabinetLabel"></strong>?
          <input type="hidden" name="cabinet_id" id="confirmCheckinCabinetId" />
          <div class="mt-3">
            <label for="confirmBarcodeInput" class="form-label">Enter Barcode</label>
            <input type="text" class="form-control" id="confirmBarcodeInput" name="barcode" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Yes, Check In</button>
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

$('#confirmCheckinModal').on('show.bs.modal', function (event) {
  const button = $(event.relatedTarget);
  const cabinetId = button.data('cabinet-id');
  const cabinetNo = button.data('cabinet-no');

  $('#confirmCheckinCabinetId').val(cabinetId);
  $('#confirmBarcodeInput').val('');
  $('#checkinCabinetLabel').text(`cabinet ${cabinetNo}`);
});

// Submit AJAX Check-In
$('#confirmCheckinForm').submit(function(e) {
  e.preventDefault();

  const cabinetId = $('#confirmCheckinCabinetId').val();
  const barcode = $('#confirmBarcodeInput').val();
  const token = $('input[name="_token"]').val();

  $.ajax({
    url: `/cabinet/checkin/${cabinetId}`,
    type: 'POST',
    data: { barcode: barcode, _token: token },
    success: function(response) {
      $('#confirmCheckinModal').modal('hide');
      window.location.reload();
      // Refresh user parcel (carousel)
      // $.ajax({
      //   url: "{{ route('cabinet.userParcels') }}",
      //   type: 'GET',
      //   success: function(data) {
      //     $('#userParcelSection').html(data);
      //     $('#userParcelCarousel').carousel({
      //       interval: false,
      //       wrap: false
      //     });
      //   }
      // });

      // // Refresh cabinet list
      // fetchCabinets(1, currentSearch, currentType, currentLocation);
    },
    error: function(xhr) {
      alert('Error during check-in. Please try again.');
      console.error(xhr.responseText);
    }
  });
});

</script>
@endpush
