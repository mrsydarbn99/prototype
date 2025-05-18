@extends('layout.app')
@section('content')
<!-- Stats Row -->
<div class="container my-5">
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
        <a href="{{ route('parcels.index') }}" class="icon-btn w-100 btn btn-outline-primary">
          <i class="fas fa-box fa-2x d-block"></i>
          <span class="label-text">Parcels</span>
        </a>
      </div>
      <div class="col-4 col-md-2 text-center">
        <a href="{{ route('cabinet.index') }}" class="icon-btn w-100 btn btn-outline-success">
          <i class="fas fa-boxes-stacked fa-2x d-block"></i>
          <span class="label-text">Cabinets</span>
        </a>
      </div>
      @hasrole('admin')
      <div class="col-4 col-md-2 text-center">
        <a href="{{ route('userlist') }}" class="icon-btn w-100 btn btn-outline-dark">
          <i class="fas fa-users fa-2x d-block"></i>
          <span class="label-text">Users</span>
        </a>
      </div>
      @endhasrole
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
      font-size: 2.5rem;
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
        document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        selectedType = btn.dataset.id;
        refTypeInput.value = selectedType;

        // Show Step 2
        step1.style.display = 'none';
        step2.style.display = 'block';
        backBtn.style.display = 'inline-block';
        submitBtn.disabled = true;
        submitBtn.style.display = 'inline-block';

        // Conditional logic: if type_id is 3 or 5, show only location_id 2
        document.querySelectorAll('.location-btn').forEach(b => {
          const locationId = b.dataset.id;
          if (selectedType === '3' || selectedType === '5') {
            b.style.display = (locationId === '2') ? 'inline-block' : 'none';
          } else {
            b.style.display = 'inline-block'; // show all
          }
        });
      });
    });

    // Step 2: Location buttons
    document.querySelectorAll('.location-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.location-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        selectedLocation = btn.dataset.id;
        refLocationInput.value = selectedLocation;

        submitBtn.disabled = false;
      });
    });

    // Back button
    backBtn.addEventListener('click', () => {
      step2.style.display = 'none';
      step1.style.display = 'block';
      backBtn.style.display = 'none';
      submitBtn.disabled = true;
      submitBtn.style.display = 'none';

      selectedLocation = null;
      refLocationInput.value = '';
      document.querySelectorAll('.location-btn').forEach(b => {
        b.classList.remove('active');
        b.style.display = 'inline-block'; // reset visibility
      });
    });

    // Reset modal on close
    const checkinModal = document.getElementById('checkinModal');
    checkinModal.addEventListener('hidden.bs.modal', () => {
      step2.style.display = 'none';
      step1.style.display = 'block';
      backBtn.style.display = 'none';
      submitBtn.disabled = true;
      submitBtn.style.display = 'none';

      selectedType = null;
      selectedLocation = null;
      refTypeInput.value = '';
      refLocationInput.value = '';
      document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.location-btn').forEach(b => {
        b.classList.remove('active');
        b.style.display = 'inline-block'; // reset visibility
      });
    });

    // On check-in submit
    checkinForm.addEventListener('submit', (e) => {
      const barcodeValue = barcodeOutside.value.trim();
      if (!barcodeValue) {
        e.preventDefault();
        alert('Please enter the barcode before checking in.');
        barcodeOutside.focus();
        return;
      }
      modalBarcode.value = barcodeValue;
    });

    // Checkout logic
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
