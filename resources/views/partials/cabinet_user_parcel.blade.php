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
                        <button class="btn btn-sm btn-outline-success w-100" 
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmCheckinModal" 
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