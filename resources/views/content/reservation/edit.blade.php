@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Reservation')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">Reservation</li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </x-breadcrumb>

    <x-page-heading>Edit Reservation</x-page-heading>

    <div class="row">
        <div class="col-12">
            @include('content.reservation.partials.nav')
            <div class="row mb-3">
                @foreach ($reservation->reservation_details as $item)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card mb-3">
                            <img class="card-img card-img-left"
                                src="{{ $item->product->getMedia('images')->first()?->getUrl() ?? $item->product->image_link }}" alt="Card image" />
                            <h5 class="card-title my-2 mx-3">{{ $item->product->name }}</h5>
                            <button class="btn btn-danger btn-pinned" data-bs-target="#deleteModal{{ $item->id }}"
                                data-bs-toggle="modal" type="button"><i class="bx bx-trash"></i></button>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteModal{{ $item->id }}"
                        aria-labelledby="deleteModal{{ $item->id }}Label" aria-hidden="true" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title fs-5" id="deleteModal{{ $item->id }}Label">
                                        {{ $item->product->name }}
                                        Deletion
                                        Confirmation</h3>
                                    <button class="btn-close" data-bs-dismiss="modal" type="button"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    Are you sure you want to delete <span
                                        class="fw-bold text-warning">{{ $item->product->name }}</span>?
                                </div>
                                <form action="{{ route('reservation-detail.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-footer justify-content-between">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"
                                            type="button">Close</button>
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12">
            <hr class="mb-3">
            <form id="addProductForm" action="{{ route('reservation.product.store') }}" method="POST">
                @csrf
                <input name="reservation_id" type="hidden" value="{{ $reservation->id }}">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label" for="product">Products</label>
                        <select class="form-select" id="product" name="product"
                            oninput="calculateTotalPrice(this.closest('form'))" required>
                            <option value="" selected disabled>Select Product</option>
                            @forelse ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @empty
                                <option value="" selected disabled>No Products Available</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="price_type">Price Type</label>
                        <select class="form-select" id="price_type" name="price_type"
                            oninput="calculateTotalPrice(this.closest('form'))" required>
                            <option value="" selected disabled>Select Type</option>
                            @foreach (App\Models\Product::$priceTypes as $type)
                                @if ($type != 'Per Day')
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                        {{ $type }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <x-input-responsive name="price" value="0" html="disabled" />
                    <div class="col-12">
                        <button class="btn btn-primary d-block ms-auto" type="submit">Add</button>
                    </div>
                </div>
            </form>
            <hr class="mb-3">
        </div>
        <form action="{{ route('reservation.update', $reservation) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <x-input-responsive name="total_discount" type="number" value="{{ $reservation->total_discount }}"
                    html="required max={{ $reservation->sub_total }}" />
                <x-input-responsive name="sub_total" value="{{ $reservation->sub_total }}" html="disabled" />
                <x-input-responsive name="grand_total" value="{{ $reservation->grand_total }}" html="disabled" />
                <x-input-responsive name="name" value="{{ $reservation->name }}" html="required" />
                <x-input-responsive name="phone_number" type="tel" value="{{ $reservation->phone_number }}"
                    html="required" />
                <x-input-responsive name="email" type="email" value="{{ $reservation->email }}" />
                <x-input-responsive class="col-md-8" name="address" value="{{ $reservation->address }}"
                    html="required" />
                <x-input-responsive name="payment_method" value="Cash On Delivery"
                    value="{{ $reservation->payment_method }}" html="required readonly" />
                <div class="col-12">
                    @csrf
                    <button class="btn btn-warning d-block ms-auto" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#total_discount').on('input', function() {
            let totalDiscountValue = $(this).val();
            let newGrandTotal = {{ $reservation->sub_total }} - totalDiscountValue;
            $('#grand_total').val(newGrandTotal);
        });

        function calculateTotalPrice(form) {
            let type = form.querySelector('select[name="price_type"]').value;
            let productID = form.querySelector('select[name="product"]').value;

            const pickupDate = new Date("{{ $reservation->pickup_date_time }}");
            const dropoffDate = new Date("{{ $reservation->dropoff_date_time }}");

            if (!isNaN(pickupDate.getTime()) && !isNaN(dropoffDate.getTime()) && type && productID) {
                const differenceInMillis = dropoffDate - pickupDate;
                const differenceInDays = parseInt(differenceInMillis / (1000 * 60 * 60 * 24));
                const reservedForDays = differenceInDays + 1;

                $.ajax({
                    type: "GET",
                    url: `/ajax/products/${productID}/show`,
                    success: function(response) {
                        const prices = JSON.parse(response.prices);
                        const price = prices[type.toLowerCase().replace(' ', '_')];
                        const pricePerDay = prices['per_day'];

                        type = parseInt(type.replace(' Day', ''));
                        const additionalDays = Math.max(reservedForDays - type, 0);
                        const additionalCharges = additionalDays * pricePerDay;

                        const total = parseInt(price) + additionalCharges;
                        form.querySelector('input[name="price"]').value = total.toFixed(3);
                    },
                    error: function(error) {
                        alert('Something Went Wrong!');
                    }
                });
            }
        }
    </script>
@endpush
