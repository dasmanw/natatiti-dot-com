@extends('layouts/contentNavbarLayout')

@section('title', 'Product Listing')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Product') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Listing') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Product Listing') }}</x-page-heading>
    <form id="filterForm" action="{{ route('product.list') }}" method="GET">
        <h4 class="py-3 mb-0">Filter & Search Products</h4>
        <div class="row">
            <div class="col-6 mb-3">
                <label class="form-label" for="search">Search</label>
                <input class="form-control" id="search" value="{{ isset($name) ? $name : '' }}" name="name"
                    type="text" placeholder="Enter product name">
            </div>
            <div class="align-content-end col-6 mb-3">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
        <div class="row">
            <x-select-responsive class="col-6 col-lg-3" name="category">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    @if (isset($categoryId))
                        <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                @endforeach
            </x-select-responsive>
            <x-input-responsive class="col-6 col-lg-3" name="height" type="number"
                value="{{ isset($height) ? $height : '' }}" html="min=1 maxlength=8" />
            <x-input-responsive class="col-6 col-lg-3" name="width" type="number"
                value="{{ isset($width) ? $width : '' }}" html="min=1 maxlength=8" />
            <x-input-responsive class="col-6 col-lg-3" name="length" type="number"
                value="{{ isset($length) ? $length : '' }}" html="min=1 maxlength=8" />
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>
        </div>
        <input id="location" name="location" value="{{ $location }}" hidden>
        <input id="pickup_date_time" name="pickup_date_time" type="datetime-local" value="{{ $pickup_date_time }}" hidden>
        <input id="dropoff_date_time" name="dropoff_date_time" type="datetime-local" value="{{ $dropoff_date_time }}"
            hidden>
    </form>

    <form action="javascript:void(0)">
        <input id="location" name="location" type="hidden" value="{{ $location }}">
    </form>
    @php
        if (str_contains($location, '_')) {
            $locationParts = explode('_', $location);
            $cityId = $locationParts[1];
        }
    @endphp
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="card h-100">
                    <img class="card-img-top"
                        src="{{ $product->getMedia('images')->first()?->getUrl() ?? $product->image_link }}"
                        alt="Card image cap" />
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p><span class="fw-bold me-2">Status: </span><span
                                class="badge rounded-pill bg-label-{{ $product->available_from ? 'danger' : 'success' }}">{{ $product->available_from ? 'Unavailable' : 'Available' }}</span>
                        </p>
                        <p><span class="fw-bold me-2">Available After:
                            </span>{{ $product->available_from ? $product->available_from : 'Now' }}
                        </p>
                        <p class="card-text">
                            {{ $product->description }}
                        </p>
                        <div>
                            <button class="btn btn-primary" data-bs-target="#showModal{{ $product->id }}"
                                data-bs-toggle="modal">Details</button>
                        </div>
                        @include('content.product.salesman.modals.show')
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="card mb-3">
                    <h4 class="mb-0 py-3">No Products Added</h4>
                </div>
            </div>
        @endforelse
    </div>
    {{ $products->onEachSide(5)->links() }}
    </div>
@endsection

@push('scripts')
    {{-- <script>
        document.getElementById('category').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    </script> --}}
    <script>
        function calculateTotalPrice(form) {
            const productID = form.getAttribute('id');
            let type = form.querySelector('select[name="price_type"]').value;
            // const discount = form.querySelector('input[name="discount"]').value;

            const pickupDate = new Date("{{ $pickup_date_time }}");
            const dropoffDate = new Date("{{ $dropoff_date_time }}");

            if (!isNaN(pickupDate.getTime()) && !isNaN(dropoffDate.getTime())) {
                const differenceInMillis = dropoffDate - pickupDate;
                const differenceInDays = parseInt(differenceInMillis / (1000 * 60 * 60 * 24));
                const reservedForDays = differenceInDays + 1;

                const prices = JSON.parse(form.querySelector('textarea').value);
                const price = prices[type.toLowerCase().replace(' ', '_')];
                const pricePerDay = prices['per_day'];

                type = parseInt(type.replace(' Day', ''));
                const additionalDays = Math.max(reservedForDays - type, 0);
                const additionalCharges = additionalDays * pricePerDay;

                const total = parseInt(price) + additionalCharges;
                // const netTotal = total - discount;
                form.querySelector('input[name="total"]').value = total.toFixed(3);
                // form.querySelector('input[name="net_total"]').value = netTotal.toFixed(3);
            }
        }

        function addToCart(button) {
            button.setAttribute('disabled', 'true');
            const form = button.closest('form');

            $.ajax({
                type: "POST",
                url: "{{ route('cart.store') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: button.getAttribute('data-id'),
                    price_type: form.querySelector('select[name="price_type"]').value,
                    pickup_date_time: "{{ $pickup_date_time }}",
                    dropoff_date_time: "{{ $dropoff_date_time }}",
                    city_id: "{{ $cityId }}",
                    // discount: form.querySelector('input[name="discount"]').value
                },
                dataType: "JSON",
                success: function(response) {
                    location.reload();
                },
                error: function(error) {
                    button.removeAttribute('disabled');
                    if (error.status == 422) {
                        form.querySelectorAll('.text-danger').forEach(element => element.remove());
                        displayValidationErrors(error.responseJSON.errors, form);
                    } else {
                        alert('Something Went Wrong');
                    }
                }
            });
        }

        function displayValidationErrors(errors, form) {
            Object.keys(errors).forEach(fieldName => {
                const input = form.querySelector(`[name="${fieldName}"]`);
                const errorMessage = errors[fieldName][0];

                input.insertAdjacentHTML('afterend', `<div class="text-danger">${errorMessage}</div>`);;
            });
        }
    </script>
@endpush
