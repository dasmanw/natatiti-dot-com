@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Warehouse')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Warehouse') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Edit Warehouse') }}</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.warehouse.partials.nav')
            <div class="card mb-4">
                <h2 class="card-header h5">{{ __('Edit') }} {{ $warehouse->name }}</h2>
                <hr class="my-0" />
                <div class="card-body">
                    <x-form action="{{ route('warehouse.update', $warehouse) }}" method="PUT">
                        <div class="row mb-3">
                            <x-input-responsive class="col-lg-3" name="name" value="{{ $warehouse->name }}"
                                html="required maxlength=50" />
                            <x-input-responsive class="col-lg-9" name="address" value="{{ $warehouse->address }}"
                                html="required maxlength=255" />
                            <div class="col-12 mb-3">
                                <label class="form-label" for="cities">{{ __('Cities') }}</label>
                                <select class="@error('cities') invalid @enderror" id="cities" name="cities[]" multiple>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ in_array($city->id, $warehouse->cities->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $city->name }}</option>
                                    @endforeach
                                </select>
                                <x-invalid-input error="cities" />
                                <x-invalid-input error="cities.*" />
                            </div>
                            <div class="col-md-3 col-lg-2 d-flex align-items-end">
                                <x-button class="warning btn-pinned mb-3">{{ __('Update') }}</x-button>
                            </div>
                        </div>
                    </x-form>
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
    <script type="module">
        new SlimSelect({
            settings: {
                placeholderText: 'Select Cities',
            },
            select: '#cities',
        })
    </script>
@endpush
