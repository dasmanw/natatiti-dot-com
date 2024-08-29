@extends('layouts/contentNavbarLayout')

@section('title', 'Make Reservation')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">Reservation</li>
        <li class="breadcrumb-item active" aria-current="page">Make</li>
    </x-breadcrumb>

    <x-page-heading>Make Reservation</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.reservation.partials.nav')
            <div class="card mb-4">
                <h2 class="card-header h5">Filter Products</h2>
                <hr class="my-0" />
                <div class="card-body">
                    <form id="filterForm" action="{{ route('product.list') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="location">Location</label>
                                <select class="@error('location') invalid @enderror" id="location"
                                    name="location" required>
                                    <option value="" selected disabled>Select Location</option>
                                    @foreach ($warehouseDetails as $governorate => $details)
                                        <optgroup label="{{ $governorate }}">
                                            @foreach ($details as $detail)
                                                <option value="{{ $detail->warehouse_id . "_" . $detail->city_id }}"
                                                    {{ $detail->warehouse_id == old('location') ? 'selected' : '' }}>
                                                    {{ $detail->city->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <x-invalid-input error="location" />
                            </div>
                            <x-input-responsive name="pickup_date_time" type="datetime-local" html="required" />
                            <x-input-responsive name="dropoff_date_time" type="datetime-local" html="required" />
                        </div>
                        <button class="btn btn-primary d-block mx-auto px-5" type="submit"><i
                                class='bx bx-search'></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="{{ asset('vendor/slimselect/slimselect.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('vendor/slimselect/slimselect.min.js') }}"></script>
    <script>
        new SlimSelect({
            select: '#location',
        });
    </script>
@endpush
