@extends('layout.app')
@section('content')
<!-- Stats Row -->
  <div class="logo">
    <img src="{{ asset('assets/dist/img/ProCabT.png') }}" alt="" width="500">
  </div>
  <div class="input-group mt-4">
    <input type="text" class="form-control" placeholder="SCAN PROBECARD BARCODE" id="barcodeOutside">
    <button class="btn btn-light search-button" type="button" data-bs-toggle="modal" data-bs-target="#checkinModal">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </div>
  <div class="d-flex justify-content-center mb-5">
    <button class="btn btn-success action-btn" data-bs-toggle="modal" data-bs-target="#checkinModal">
      CHECK-IN PARCEL
    </button>
    <button class="btn btn-danger action-btn" data-bs-toggle="modal" data-bs-target="#checkoutConfirmModal">
      CHECK-OUT PARCEL
    </button>
  </div>
  <div class="container nav-icons mt-5">
    <div class="row justify-content-center">
      <div class="col-4 col-md-2 text-center">
        <div class="icon-btn">
          <i class="fas fa-box"></i>
        </div>
        <div class="label-text">Parcel</div>
      </div>
      <div class="col-4 col-md-2 text-center">
        <div class="icon-btn">
          <i class="fas fa-boxes-stacked"></i>
        </div>
        <div class="label-text">Cabinet</div>
      </div>
      <div class="col-4 col-md-2 text-center">
        <div class="icon-btn">
          <i class="fas fa-user"></i>
        </div>
        <div class="label-text">Admin</div>
      </div>
    </div>
  </div>

  <!-- Check-in Modal -->
    <div class="modal fade" id="checkinModal" tabindex="-1" aria-labelledby="checkinModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 30%;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Select Type</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body text-center">
            <form id="checkinForm" action="{{ route('cabinet.checkin') }}" method="POST">
              @csrf
              <input type="hidden" name="ref_type_id" id="ref_type_id" value="">
              <input type="hidden" name="ref_location_id" id="ref_location_id" value="">
              <input type="hidden" name="barcode" id="modal_barcode" value="">

              <!-- Step 1: Select Type -->
              <div id="step1">
                <p>Please select the parcel type:</p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                  @foreach ($types as $type)
                    <button type="button" class="btn btn-outline-primary type-btn" data-id="{{ $type->id }}">{{ $type->name }}</button>
                  @endforeach
                </div>
              </div>

              <!-- Step 2: Select Location -->
              <div id="step2" style="display: none;">
                <p>Please select the location:</p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                  @foreach ($locations as $location)
                    <button type="button" class="btn btn-outline-secondary location-btn" data-id="{{ $location->id }}">{{ $location->name }}</button>
                  @endforeach
                </div>
              </div>

              <div class="mt-3">
                <button type="button" class="btn btn-secondary" id="backBtn" style="display: none;">Back</button>
                <button type="submit" class="btn btn-success" id="submitBtn" disabled>Confirm Check-In</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Check-Out Confirmation Modal -->
    <div class="modal fade" id="checkoutConfirmModal" tabindex="-1" aria-labelledby="checkoutConfirmModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content">
          <form id="checkoutForm" action="{{ route('cabinet.checkout') }}" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title">Confirm Check-Out</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <p>Are you sure you want to check out this parcel?</p>
              <input type="hidden" name="barcode" id="checkout_barcode" value="">
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Yes, Check-Out</button>
            </div>
          </form>
        </div>
      </div>
    </div>
@endsection

@push('css')
  <style>
    .input-group {
      max-width: 600px;
      margin: 20px auto;
    }
    .search-button {
      border: 1px solid #ced4da;
      border-left: 0;
      background-color: white;
      color: #6c757d;
    }
    .action-btn {
      margin: 10px;
      width: 180px;
      height: 50px;
      font-weight: bold;
      font-size: 1rem;
    }
    .nav-icons .col {
      margin-top: 40px;
    }
    .icon-btn {
      background-color: #ffe066;
      border-radius: 20px;
      padding: 20px;
    }
    .icon-btn img {
      width: 50px;
      height: 50px;
    }
    .icon-btn i {
      font-size: 2.5rem; /* Adjust size as needed */
    }
    .label-text {
      margin-top: 10px;
      font-weight: bold;
    }
    .logo {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem 0;
        text-align: center;
    }
    .type-btn.active,
    .location-btn.active {
      background-color: #0d6efd;
      color: white;
      border-color: #0d6efd;
    }
  </style>
@endpush

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const backBtn = document.getElementById('backBtn');
    const submitBtn = document.getElementById('submitBtn');
    const refTypeInput = document.getElementById('ref_type_id');
    const refLocationInput = document.getElementById('ref_location_id');
    const barcodeOutside = document.getElementById('barcodeOutside');
    const modalBarcode = document.getElementById('modal_barcode');
    const checkinForm = document.getElementById('checkinForm');

    let selectedType = null;
    let selectedLocation = null;

    // Step 1: Type buttons
    document.querySelectorAll('.type-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        // Mark active
        document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        selectedType = btn.dataset.id;
        refTypeInput.value = selectedType;

        // Move to Step 2: Location select
        step1.style.display = 'none';
        step2.style.display = 'block';
        backBtn.style.display = 'inline-block';
        submitBtn.disabled = true; // wait for location selection
        submitBtn.style.display = 'inline-block';
      });
    });

    // Step 2: Location buttons
    document.querySelectorAll('.location-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        // Mark active
        document.querySelectorAll('.location-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        selectedLocation = btn.dataset.id;
        refLocationInput.value = selectedLocation;

        // Enable submit
        submitBtn.disabled = false;
      });
    });

    // Back button to go back to Step 1
    backBtn.addEventListener('click', () => {
      step2.style.display = 'none';
      step1.style.display = 'block';
      backBtn.style.display = 'none';
      submitBtn.disabled = true;
      submitBtn.style.display = 'none';

      // Reset location selection
      selectedLocation = null;
      refLocationInput.value = '';
      document.querySelectorAll('.location-btn').forEach(b => b.classList.remove('active'));
    });

    // When modal closes, reset all
    const checkinModal = document.getElementById('checkinModal');
    checkinModal.addEventListener('hidden.bs.modal', () => {
      // Reset to step 1
      step2.style.display = 'none';
      step1.style.display = 'block';
      backBtn.style.display = 'none';
      submitBtn.disabled = true;
      submitBtn.style.display = 'none';

      // Reset selections
      selectedType = null;
      selectedLocation = null;
      refTypeInput.value = '';
      refLocationInput.value = '';
      document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.location-btn').forEach(b => b.classList.remove('active'));
    });

    // On form submit, copy the outside barcode input value into hidden input
    checkinForm.addEventListener('submit', (e) => {
      const barcodeValue = barcodeOutside.value.trim();

      if (!barcodeValue) {
        e.preventDefault();
        alert('Please enter the barcode before checking in.');
        // Optionally, you could close the modal or focus input
        barcodeOutside.focus();
        return;
      }

      modalBarcode.value = barcodeValue;
    });

    const checkoutForm = document.getElementById('checkoutForm');
    const checkoutModalBarcode = document.getElementById('checkout_barcode');

    if (checkoutForm) {
      checkoutForm.addEventListener('submit', (e) => {
        const barcodeValue = barcodeOutside.value.trim();

        if (!barcodeValue) {
          e.preventDefault();
          alert('Please enter the barcode before checking out.');
          barcodeOutside.focus();
          return;
        }

        checkoutModalBarcode.value = barcodeValue;
      });
    }

    const checkoutModal = document.getElementById('checkoutModal');
    if (checkoutModal) {
      checkoutModal.addEventListener('hidden.bs.modal', () => {
        checkoutBarcodeOutside.value = '';
        barcodeOutside.value = '';
      });
    }

  });
</script>
@endpush
